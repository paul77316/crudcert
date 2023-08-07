@extends('layouts.dashboard')
@section('title','certificates')

@section('content')
    <div class="d-flex justify-content-end">
    </div>
    <div class="container pm-certificate-container" id="print_area" >
        <div class="outer-border"></div>
        <div class="inner-border"></div>
        
        <div class="pm-certificate-border col-xs-12">
        <div class="row pm-certificate-header">
            <div class="pm-certificate-title cursive col-xs-12 text-center">
            <h2>Certificate of Completion</h2>
            </div>
        </div>
        <div class="row pm-certificate-header">
            <div class="pm-certificate-title col-xs-12 text-center">
            <h5>This is certify that</h5>
            </div>
        </div>

        <div class="row pm-certificate-body">
            
            <div class="pm-certificate-block">
                <div class="col-xs-12">
                <div class="row">
                    <div class="col-xs-2"><!-- LEAVE EMPTY --></div>
                    <div class="pm-certificate-name underline margin-0 col-xs-8 text-center">
                    <span class="pm-name-text bold">{{$arr['name']}}</span>
                    </div>
                    <div class="col-xs-2"><!-- LEAVE EMPTY --></div>
                </div>
                </div>          

                <div class="col-xs-12">
                <div class="row">
                    <div class="col-xs-2"><!-- LEAVE EMPTY --></div>
                    <div class="pm-earned col-xs-8 text-center">
                    <span class="pm-earned-text padding-0 block">has completed {{$arr['course_name']}} from {{date('F j, Y', strtotime($arr['from']))}} to {{date('F j, Y', strtotime($arr['date_completed']))}}</span>
                    </div>
                    <div class="col-xs-2"><!-- LEAVE EMPTY --></div>
                    <div class="col-xs-12"></div>
                </div>
                </div>      
            
            <div class="col-xs-12">
            <div class="row">
                <div class="pm-certificate-footer">
                    <div class="col-xs-4 pm-certified col-xs-4 text-center">
                    <span class="pm-credits-text block sans">TrainCourse Bootcamp</span>
                    <span class="pm-empty-space block underline">Admin</span>
                    <span class="bold block">Administrator</span>
                    </div>
                    <div class="col-xs-4">
                    <!-- LEAVE EMPTY -->
                    </div>
                </div>
            </div>
            </div>

        </div>

        </div>
    </div>
@endsection

@section('script')
@endsection
