<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Http\Resources\CityResource;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\CustomerUpdateResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\StatusResource;
use App\Models\City;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    private function getProduct(Request $request)
    {
        $query = Product::orderBy('created_at', 'desc');

        if ($search = $request->input('search')) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        return $query->paginate(
            perPage: $request->input('limit', 10),
            page: $request->input('page', 1)
        );
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = $this->getProduct($request);
        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerRequest $request)
    {
        $data = $request->validated();
        $user = Auth::user();

        $customer = new Customer();
        $customer->customer_name = $data['name'];
        $customer->customer_company = $data['company'];
        $customer->customer_phone = $data['phone'];
        $customer->customer_email = $data['email'];
        $customer->customer_address = $data['address'];
        $customer->customer_city = $data['city'];
        $customer->customer_note = $data['note'];
        $customer->customer_status = $data['status'];
        $customer->created_by = $user->id;
        $customer->save();

        return new CustomerResource($customer);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid)
    {
        $customer = Customer::where('uuid', $uuid)->firstOrFail();
        return new CustomerUpdateResource($customer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $uuid, CustomerRequest $request)
    {
        $data = $request->validated();

        $customer = Customer::where('uuid', $uuid)->firstOrFail();
        $customer->customer_name = $data['name'];
        $customer->customer_company = $data['company'];
        $customer->customer_phone = $data['phone'];
        $customer->customer_email = $data['email'];
        $customer->customer_address = $data['address'];
        $customer->customer_city = $data['city'];
        $customer->customer_note = $data['note'];
        $customer->customer_status = $data['status'];
        $customer->save();

        return new CustomerResource($customer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }

    public function list(Request $request)
    {
        $user = Auth::user();
        $customers = Customer::orderBy('created_at', 'desc')->get();
        return CustomerResource::collection($customers);
    }

    public function cities(Request $request)
    {
        $cities = City::all();
        return CityResource::collection($cities);
    }

    public function status(Request $request)
    {
        $cities = Status::all();
        return StatusResource::collection($cities);
    }
}
