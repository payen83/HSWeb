@extends('layouts.app')

@section('content') 
            <!-- Main Container -->
            <main id="main-container">
                <!-- Side Content and Products -->
                <section class="content content-boxed">
                    <div class="row">
                        <div class="col-lg-3">
                            <!-- Buttons which toggles side nav content content in smaller screens -->
                            <!-- Toggle class helper (for .js-nav-content below), functionality initialized in App() -> uiToggleClass() -->
                            <div class="block hidden-lg">
                                <div class="block-content">
                                    <button class="btn btn-sm btn-block btn-default push" type="button" data-toggle="class-toggle" data-target=".js-nav-content" data-class="visible-lg">
                                        <i class="fa fa-list-ul push-5-r"></i> Navigation
                                    </button>
                                </div>
                            </div>

                            
                        </div>
                        <div class="col-lg-9">
                            <!-- Sort and Show Filters -->
                            <div class="form-inline clearfix">
                                <select id="ecom-results-show" name="ecom-results-show" class="form-control push pull-right" size="1">
                                    <option value="0" disabled selected>SHOW</option>
                                    <option value="9">9</option>
                                    <option value="18">18</option>
                                    <option value="36">36</option>
                                    <option value="72">72</option>
                                </select>
                                <select id="ecom-results-sort" name="ecom-results-sort" class="form-control push" size="1">
                                    <option value="0" disabled selected>SORT BY</option>
                                    <option value="1">Popularity</option>
                                    <option value="2">Name (A to Z)</option>
                                    <option value="3">Name (Z to A)</option>
                                    <option value="4">Price (Lowest to Highest)</option>
                                    <option value="5">Price (Highest to Lowest)</option>
                                    <option value="6">Sales (Lowest to Highest)</option>
                                    <option value="7">Sales (Highest to Lowest)</option>
                                </select>
                            </div>
                            <!-- END Sort and Show Filters -->
                            @foreach($products as $key=>$data)
                            <!-- Products -->
                            <div class="row">
                                <div class="col-sm-6 col-lg-4">
                                    <div class="block">
                                        <div class="img-container">
                                            <center><img  src="{{ url('/') }}/upload/images/<?php echo $data->ImageURL; ?>" alt="" width="200" height="300"></center>
                                            <div class="img-options">
                                                <div class="img-options-content">
                                                    <div class="push-20">
                                                        <a class="btn btn-sm btn-default" href="base_pages_ecom_store_product.html">View</a>
                                                        <a class="btn btn-sm btn-default" href="javascript:void(0)">
                                                            <i class="fa fa-plus"></i> Add to cart
                                                        </a>
                                                    </div>
                                                    <div class="text-warning">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <span class="text-white">(998)</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="block-content">
                                            <div class="push-10">
                                                <div class="h4 font-w600 text-success pull-right push-10-l">${{$data->Price}}</div>
                                                <a class="h4" href="base_pages_ecom_store_product.html">{{$data->Name}}</a>
                                            </div>
                                            <p class="text-muted">Management for freelancers</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                <div class="col-xs-12 push">
                                    <ul class="pager">
                                        <li class="next">
                                            <a href="javascript:void(0)">Next <i class="fa fa-arrow-right"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- END Products -->
                        </div>
                    </div>
                </section>
                <!-- END Side Content and Products -->
            </main>
            <!-- END Main Container -->
@endsection