<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\CompanyCollection;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Http\Resources\CompanyReviewsResource;
use App\Http\Resources\CompanyReviewsCommentsResource;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index','show','getTwoCompanies']);
        $this->middleware('admin_check')->only(['restoreCompany']);
        $this->middleware('manager_check')->only(['getManagerCompanies']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies =  Company::with('user','reviews')->where('deleted',false)->latest()->get();
        return  CompanyReviewsResource::collection($companies);

    }
    public function getManagerCompanies()
    {
        $companies = Company::with('user','reviews')->where('user_id',JWTAuth::user()->id)->where('deleted',0)->latest()->get();
        return  CompanyReviewsResource::collection($companies);
    }
    public function getAllCompanies()
    {
        $companies = Company::with('user','reviews')->latest()->get();
        return  CompanyReviewsResource::collection($companies);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCompanyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCompanyRequest $request)
    {
        $company = Company::create([
            'name'=>$request->name,
            'website'=>$request->website,
            'logo'=>$request->logo,
            'founded'=>$request->foundation_year,
            'industry_id'=>$request->industry, 
            'user_id'=>JWTAuth::user()->id,
            'employees'=>$request->employees, 
            'revenue'=>$request->revenue, 
            'description'=>$request->description,
            'city'=>$request->city,
            'country_code'=>$request->country_code,
            'address'=>$request->address,
            'mission'=>$request->mission,
        ]);
        $companies =  Company::with('user','reviews')->where('deleted',false)->latest()->get();
        return  CompanyReviewsResource::collection($companies);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show($name)
    {
        $name = str_replace('-',' ',$name);
        $company =  Company::with('reviews')->where('name',$name)->where('deleted',0)->first();
        if(!$company)   return response()->json(['message'=>'Company not found'],404);
        else  return  new CompanyReviewsCommentsResource($company);
    }
    public function getTwoCompanies($name1,$name2){
        $name1 = str_replace('-',' ',$name1);
        $name2 = str_replace('-',' ',$name2);
        $companies =  Company::with('reviews')->where('name',$name1)->orWhere('name',$name2)->where('deleted',0)->latest()->get();
        if($companies && count($companies)==2){
            return  CompanyReviewsCommentsResource::collection($companies);
        }
        return response()->json(['message'=>'Companies not found'],404);

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCompanyRequest  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCompanyRequest $request, Company $company)
    {
        
        
        $company->update([
            'name'=>$request->name,
            'website'=>$request->website,
            'logo'=>$request->logo,
            'founded'=>$request->foundation_year,
            'industry_id'=>$request->industry, 
            'employees'=>$request->employees, 
            'revenue'=>$request->revenue, 
            'description'=>$request->description,
            'city'=>$request->city,
            'country_code'=>$request->country_code,
            'address'=>$request->address,
            'mission'=>$request->mission,
       ]);
       $companies =  Company::with('user','reviews')->where('deleted',false)->latest()->get();
        return  CompanyReviewsResource::collection($companies);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $company = Company::find($company->id);
        $company->delete();
        return  response()->json(['success'=>'company deleted  successufuly']);
    }
    public function deleteCompany($id)
    {
        $company = Company::findOrFail($id)->where('user_id',JWTAuth::user()->id);
        $company->deleted = 1;
        $company->save();
        return  response()->json(['success'=>'company deleted successufuly']);
    }
    public function restoreCompany($id){
        $company = Company::findOrFail($id);
        $company->deleted = 0;
        $company->save();
        return  response()->json(['success'=>'company restored successufuly']);
    }
}
