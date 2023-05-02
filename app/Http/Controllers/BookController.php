<?php

namespace App\Http\Controllers;

use App\Http\Requests\Book\StoreRequest;
use App\Http\Requests\Book\UpdateRequest;
use App\Jobs\DeleteBookJob;
use App\Models\Book;
use App\Traits\ApiResponser;
use App\Traits\WithErrorHandling;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class BookController extends Controller
{
    use WithErrorHandling,ApiResponser;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->withErrorHandling(function (){
            $books = Cache::remember('books', 60, function () {
                return Book::with('author')->get();
            });
            return $this->successResponse($books);
        });
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        return $this->withErrorHandling(function () use($request) {
            $data = $request->validated();
            $book = Book::create($data);
            if($book) {
                return $this->successResponse($book, 'Book Successfully Created', Response::HTTP_CREATED);
            }
            return $this->errorResponse('Date not store, kindly do this request again', Response::HTTP_UNPROCESSABLE_ENTITY);
        });
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return $this->withErrorHandling(function () use($id){
            $book = Book::with('author')->findOrFail($id);
            if($book){
                return $this->successResponse($book);
            }
            return $this->errorResponse('Page Not Found',Response::HTTP_NOT_FOUND);
        });
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request,$id)
    {
        return $this->withErrorHandling(function () use($request,$id){
            $book = Book::findOrFail($id);
            if($book){
                $data = $request->validated();
                $book->update($data);
                $success = $book->save();
                if($success){
                    return $this->successResponse($book, 'Book Successfully Updated');
                }
                return $this->errorResponse('Date not store, kindly do this request again', Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            return $this->errorResponse('Page Not Found',Response::HTTP_NOT_FOUND);
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $book = Book::find($id);
        DeleteBookJob::dispatch($book);
        return response()->noContent();
    }
}
