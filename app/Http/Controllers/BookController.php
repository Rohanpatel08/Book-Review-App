<?php

namespace App\Http\Controllers;

use App\DataTables\BookDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookStoreRequest;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, BookDataTable $dataTable)
    {

        return $dataTable->render('books.list');
        // $query = Book::query();
        // if ($request->ajax()) {
        //     $books = $query->get();
        //     return DataTables::of($books)
        //         ->addIndexColumn()
        //         ->addColumn('status', function ($book) {
        //             return $book->status == 1 ? '<span class="text-success">Active</span>' : '<span class="text-danger">Inactive</span>';
        //         })
        //         ->addColumn('Action', function ($row) {
        //             $btn = '<a href="" class="btn btn-primary btn-sm"><i class="fa-regular fa-star"></i></a>
        //                     <a href="books/' . $row->id . '/edit" class="btn btn-warning btn-sm"><i class="fa-regular fa-pen-to-square"></i></a>
        //                     <a href="#" class="btn btn-danger btn-sm" onclick="deleteBook(' . $row->id . ')"><i class="fa-solid fa-trash"></i></a>';
        //             return $btn;
        //         })
        //         ->rawColumns(['status', 'Action'])
        //         ->make(true);
        // }
        // return view('books.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookStoreRequest $request)
    {
        if (!empty($request->image)) {
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imgName = time() . '.' . $ext;
            $image->move(public_path('storage/uploads/books'), $imgName);
        }
        Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'description' => $request->description,
            'image' => !empty($request->image) ? $imgName : null,
            'status' => $request->status
        ]);

        return redirect()->route('books.index')->with('success', 'Book added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book = Book::find($id);
        return view('books.view', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $book = Book::find($id);
        return view('books.edit', ['book' => $book]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $book = Book::find($id);

        if (!empty($request->image)) {
            if (isset($book->image)) {
                $path = public_path('storage/uploads/books/' . $book->image);
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imgName = time() . '.' . $ext;
            $image->move(public_path('storage/uploads/books'), $imgName);
            $book->image = $imgName;
        }
        $book->title = $request->title;
        $book->author = $request->author;
        $book->description = $request->description;
        $book->status = $request->status;
        $book->update();
        return redirect()->route('books.index')->with('success', 'Book updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);
        if ($book == "") {
            return response()->json([
                'status' => false,
                'message' => 'Book not found',
            ]);
        } else {
            $path = public_path('storage/uploads/books/' . $book->image);
            if (isset($book->image)) {
                unlink($path);
            }
            $book->delete();

            return response()->json([
                'status' => true,
                'message' => 'Book deleted successfully',
            ]);
        }
    }
}
