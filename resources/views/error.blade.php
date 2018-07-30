 @extends('layouts.backg')

 <!-- Error Content -->
        <div class="content bg-white text-center pulldown overflow-hidden">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <!-- Error Titles -->
                    <h1 class="font-s128 font-w300 text-flat animated bounceIn">403</h1>
                    <h2 class="h3 font-w300 push-50 animated fadeInUp">We are sorry but you do not have permission to access this page</h2>
                    <!-- END Error Titles -->
                    <a href="{{url('/logout')}}" <button class="btn btn-sm btn-danger" type="submit" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Back</button></a>
                     <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                      {{ csrf_field() }}
                   
                </div>
            </div>
        </div>
<!-- END Error Content -->