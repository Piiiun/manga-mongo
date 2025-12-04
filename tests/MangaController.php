use App\Models\Manga;

public function index()
{
    $mangas = Manga::with('genres')->paginate(16); // tampil 16 per halaman

    return view('page-manga-list', compact('mangas'));
}
