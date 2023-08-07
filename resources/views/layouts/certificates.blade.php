@extends('layouts.dashboard')
@section('title','certificates')

@section('content')
    <h3>My Certicates</h3>
    <div class="container-fluid">
        <div class="row" id="">
            @if(count($certificat))
             @foreach ($certificat as $item)
                <div class="col-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    {{$item->date_completed}}</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{$item->course_name}}</div>
                                    <div class="mt-3">
                                        <a href="/viewcert/{{$item->id}}">
                                            <button class="btn btn-sm btn-info">View</button>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa fa-certificate fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            @else
                <div class="mt-5">
                    <h5>No Certificates Yet</h5>

                </div>
            @endif
         
        </div>
    </div>
@endsection

@section('script')
<script>
    
</script>
@endsection
