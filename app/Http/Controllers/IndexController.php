<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TestUser;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class IndexController extends Controller
{

    /**
     * Acceso al listado de inicio
     * 
     * GET: /
     * 
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        
        $users = TestUser::all();
        
        return view('index', ['users' => $users]);
    }

    /**
     * Acceso a la vista de creación
     *
     * GET: /crear-usuario
     *
     */
    public function createView()
    {
        $data = [
            'action' => route('testuser.create'),
            'title'  => 'Crear',
        ];
        
        return view('form', ['data' => $data]);
    }
    
    /**
     * Acceso a la vista de editar
     * 
     * GET:/editar-usuario/{id}
     * 
     * @param TestUser $user
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function editView(TestUser $user) {
        
        $password = Crypt::decryptString($user->password);
        
        $data = [
            'action' => route('testuser.edit'),
            'title'  => 'Editar',
            'user' => $user,
            'password' => $password,
        ];
       
        
        return view('form', ['data' => $data]);
        
    }
    
    /**
     * Post del formulario de crear
     * 
     * POST: /create
     * 
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function create(Request $request)
    {
        try {
            DB::beginTransaction();
            $user = new TestUser();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->average = $request->average;
            $user->birthdate = $request->birthdate;
            
            //Encriptamos la contraseña
            $password = Crypt::encryptString($request->password);
            $user->password = $password;
            

            $user->save();
            
            //Comprobamos la imagen
            if ($request->hasFile('image')) {
                //Subimos la imagen
                $request->file('image')->storeAs('images', $user->id.'.jpg');
            }
            
            DB::commit();
            
            return redirect('/');
        
        }
        catch (\Exception $e) {
            DB::rollBack();
            Log::debug($e);
            return redirect('/');
            
        }
    }
    
    
    /**
     * Post del formulario de editar
     * 
     * POST: /edit
     * 
     * @param Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function edit (Request $request) {
        try {
            DB::beginTransaction();
            $user = TestUser::find($request->id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->average = $request->average;
            $user->birthdate = $request->birthdate;
            
            //Encriptamos la contraseña
            $password = Crypt::encryptString($request->password);
            $user->password = $password;
            
            $user->save();
            
            //Comprobamos la imagen
            if ($request->hasFile('image')) {
                if(Storage::disk('images')->exists($user->id.'.jpg')){ 
                    Storage::disk('images')->delete($user->id.'.jpg');
                }
                
                //Subimos la imagen
                $request->file('image')->storeAs('images', $user->id.'.jpg');
            }
            
            
            
            DB::commit();
            
            return redirect('/');
            
        }
        catch (\Exception $e) {
            DB::rollBack();
            Log::debug($e);
            return redirect('/', ['message' => $message]);
            
        }
    }
    
    /**
     * Acción de borrar
     * 
     * POST: /delete
     * 
     * @param Request $request
     * @return string
     */
    public function delete (Request $request) {
        try {
            DB::beginTransaction();
            TestUser::find($request->id)->delete();
            //Eliminamos la imagen si la hay
            if(Storage::disk('images')->exists($request->id.'.jpg')){
                Storage::disk('images')->delete($request->id.'.jpg');
            }
            DB::commit();
            return json_encode(true);
        } catch(\Exception $e) {
            Log::debug($e);
            DB::rollBack();
            return json_encode(false);
        }
    }
}

