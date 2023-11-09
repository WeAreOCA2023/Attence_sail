@extends('layouts.fixed')

@section('content')
<div class="profile d-flex justify-content-center h-100 w-100 mx-auto py-4">
    <div class="upperBox">
        <div class="icon">
            <h3>Anderson Jennifer</h3>
        </div>
        <div class="personal">
            <div class="yourSetting">

            </div>
            <div class="companyInfo">

            </div>
            <div class="tasks">
                
            </div>
        </div>
    </div>
    <div class="lowerBox">
        <div class="low">

        </div>
        @can('boss')
        <div class="company">

        </div>
        @endcan
    </div>

</div>
@endsection