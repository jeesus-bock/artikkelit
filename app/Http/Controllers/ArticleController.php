<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Article;
use App\Models\ArticleTag;
use App\Events\ArticleEditing;


class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $articles = Article::where('draft', false)->get();
        foreach($articles as $article) {
            $article->user;
            $article->updater;
            $article['tags'] = ArticleTag::where('article_id','=',$article->id)->get()->map(function (ArticleTag $articleTag) { return $articleTag->tag; });
        }
        return Inertia::render('Articles/All', [
            'articles' => $articles,
        ]);
        
    }
    public function ownindex(Request $request): Response
    {
        $articles = Article::where('user_id', $request->user()->id)->orWhere('multi', true)->get();
        foreach($articles as $article) {
            $article->user;
            $article->updater;
            $article['tags'] = ArticleTag::where('article_id','=',$article->id)->get()->map(function (ArticleTag $articleTag) { return $articleTag->tag; });
        }
        return Inertia::render('Articles/Own', [
            'articles' => $articles,
            'success' => $request->session()->get('success')
        ]);
        
    }
  
    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Articles/Edit');
        
    }
  
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);
        $arr = $request->all();
        $arr['user_id'] = $request->user()->id;
        $arr['updated_by'] = $request->user()->id;
        
        Article::create($arr);
         
        return redirect()->route('articles.own')
                        ->with('success','Artikkeli luotu onnistuneesti.');
    }
  
    /**
     * Display the specified resource.
     */
    public function show(Article $article): Response
    {
        return Inertia::render('Articles/View', [
            'article' => $article,
        ]);    
    }
  
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Article $article): Response
    {
        ArticleEditing::dispatch($article->id, true, $request->user()->name);
        $arr = $article->toArray();
        $arr['editing'] = $request->user()->name;
        $article->update($arr);
        return Inertia::render('Articles/Edit', [
            'article' => $article,
        ]);
        
    }
  
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article): RedirectResponse
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);
        $arr = $request->all();
        $arr['updated_by'] = $request->user()->id;
        $arr['editing'] = null;
        $article->update($arr);
        
        return redirect()->route('articles.own')
                        ->with('success','Artikkeli päivitetty onnistuneesti.');
    }
  
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article): RedirectResponse
    {
        $article->delete();
         
        return redirect()->route('articles.own')
                        ->with('success','Artikkeli poistettu onnistuneesti.');
    }
}