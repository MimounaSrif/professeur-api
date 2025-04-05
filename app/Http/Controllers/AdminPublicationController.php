namespace App\Http\Controllers;

use App\Models\Publication;
use Illuminate\Http\Request;

class AdminPublicationController extends Controller
{
    // 🔹 Liste des publications
    public function index()
    {
        $publications = Publication::orderByDesc('created_at')->get();
        return response()->json(['publications' => $publications]);
    }

    // 🔹 Archiver une publication
    public function archive($id)
    {
        $publication = Publication::findOrFail($id);
        $publication->archived = true;
        $publication->save();

        return response()->json(['message' => 'Publication archivée avec succès']);
    }
}
