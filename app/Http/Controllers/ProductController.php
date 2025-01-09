<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
  public function __construct()
  {
    $this->middleware('role:admin')->only(['create', 'edit', 'destroy', 'store', 'update']);
    $this->middleware('role:admin|viewer')->only(['index', 'show']);
  }

  /**
   * Display a listing of the user.
   *
   * @param  Request  $request
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $products =  Product::filter($request->all());
    $ascending = isset($query['ascending']) ? $query['ascending'] : 'desc';
    $orderBy = isset($query['order_by']) ? $query['order_by'] : 'name';

    return view('products.index', compact('products', 'ascending', 'orderBy'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('products.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $request->validate([
      'name' => ['required', 'string', 'max:255', Rule::unique('products', 'name')],
    ]);

    $input = $request->all();

    Product::create([
      'name' => $input['name'],
    ]);

    $resp = [
      'message' => __('Produto Cadastrado com Sucesso!'),
      'alert-type' => 'success'
    ];

    return redirect()->route('products.index')->with($resp);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $product = Product::findOrFail($id);
    return view('products.show', compact('product'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $product = Product::findOrFail($id);
    return view('products.edit', compact('product'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $product = Product::findOrFail($id);

    $request->validate([
      'name' => ['required', 'string', 'max:255', Rule::unique('products', 'name')->ignore($product->id)],
    ]);

    $input = $request->all();

    $product->update([
      'name' => $input['name'],
    ]);

    $resp = [
      'message' => __('Produto Atualizado com Sucesso!'),
      'alert-type' => 'success'
    ];

    return redirect()->route('products.index')->with($resp);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $product = Product::findOrFail($id);

    $product->delete();

    return response()->json([
      'message' => __('Produto Apagado com Sucesso!!'),
      'alert-type' => 'success'
    ]);
  }

  /**
   * Filter product
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function filter(Request $request)
  {
    $products = Product::filter($request->all());
    $products = $products->setPath('');
    $orderBy = $request->get('order_by');
    $ascending = $request->get('ascending');
    $paginatePerPage = $request->get('paginate_per_page');

    return response()->json([
      'filter_result' => view('products.filter-result', compact('products', 'orderBy', 'ascending'))->render(),
      'pagination' => view('layouts.pagination', [
        'models' => $products,
        'order_by' => $orderBy,
        'ascending' => $ascending,
        'paginate_per_page' => $paginatePerPage,
      ])->render(),
    ]);
  }
}
