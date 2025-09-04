<?php

namespace App\Http\Controllers;


use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="ZTF Foundation API Documentation",
 *     description="API Documentation for ZTF Foundation User Management",
 *     @OA\Contact(
 *         email="admin@ztffoundation.com",
 *         name="ZTF Foundation Team"
 *     )
 * )
 * 
 * @OA\Server(
 *     description="ZTF Foundation API Server",
 *     url=L5_SWAGGER_CONST_HOST
 * )
 */
class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/register",
     *     tags={"Authentication"},
     *     summary="Affiche le formulaire d'inscription final",
     *     description="Retourne la vue du formulaire d'inscription",
     *     @OA\Response(
     *         response=200,
     *         description="Vue du formulaire d'inscription"
     *     )
     * )
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Traite le formulaire d'inscription final
     */


    /**
     * @OA\Get(
     *     path="/users",
     *     tags={"Users"},
     *     summary="Liste tous les utilisateurs",
     *     description="Retourne la liste de tous les utilisateurs avec leurs services et départements",
     *     @OA\Response(
     *         response=200,
     *         description="Liste des utilisateurs récupérée avec succès",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="email", type="string"),
     *                 @OA\Property(property="matricule", type="string"),
     *                 @OA\Property(property="services", type="array", @OA\Items(type="object")),
     *                 @OA\Property(property="departments", type="array", @OA\Items(type="object"))
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        
        $users = User::with('services', 'departments')->get();
        return view('staff.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('staff.create');
    }

    public function edit(){
        $user = auth()->user();
        return view('profile.edit', compact('user'));
   }

    /**
     * @OA\Put(
     *     path="/users/{user}",
     *     tags={"Users"},
     *     summary="Met à jour les informations d'un utilisateur",
     *     description="Met à jour le matricule, l'email et le mot de passe d'un utilisateur",
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         required=true,
     *         description="ID de l'utilisateur",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"matricule","email","password"},
     *             @OA\Property(property="matricule", type="string", example="CM-HQ-IT-001"),
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="password", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Utilisateur mis à jour avec succès"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function update(Request $request , User $user){
        $data=$request->validate([
             
            'matricule' => [
                'required',
                'string',
                'max:255',
                'regex:/^CM-HQ-[a-zA-Z]+-\d{3}$/'
            ],
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'matricule.regex' => "Le matricule doit être au format : CM-HQ-nomdepartement-numerosequentiel (ex: CM-HQ-IT-001)"
        
        ]);
        $user=Auth::user();

        $user->update($data);
        return redirect(route('users.update'));
    }
    /**
     * @OA\Delete(
     *     path="/users/{user}",
     *     tags={"Users"},
     *     summary="Supprime un utilisateur",
     *     description="Supprime définitivement un utilisateur de la base de données",
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         required=true,
     *         description="ID de l'utilisateur à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Utilisateur supprimé avec succès"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Utilisateur non trouvé"
     *     )
     * )
     */
    public function destroy(User $user)
    {
        $sexe = $user->sexe == 'M' ? 'Mr' : 'Mme';
        $user->delete();
        return redirect()->route('staff.index')->with('success', "$sexe {$user->name} {$user->surname} supprimé avec succès");
    }

    /**
     * @OA\Get(
     *     path="/api/v1/getAllUsers",
     *     tags={"Users"},
     *     summary="Récupère tous les utilisateurs",
     *     description="Retourne la liste de tous les utilisateurs",
     *     @OA\Response(
     *         response=200,
     *         description="Liste des utilisateurs récupérée avec succès"
     *     )
     * )
     */
    public function getAllUsers() {
        try {
            $users = User::all();
            return response()->json([
                'status' => 'success',
                'data' => $users
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function dashboard(){
        return view('staff.dashboard');
    }
}
