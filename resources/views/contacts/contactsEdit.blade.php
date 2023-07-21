@extends('layout.app')
@section('main')
    <div class="container mt-5">
        <div class="row d-flex justify-content-center text-center">
            <div class="col-sm-8 ">
                <div class="card mt-3 bg-info">
                    <h3 class="text-center">Enter Details Of Contact</h3>
                    <form enctype="multipart/form-data" class="p-3">
                        @csrf
                        <div class="form-control border-0 bg-info row d-flex justify-content-center  ">
                            <label for="">Contact Name</label>
                            <input class="form-control w-50 " type="text" id="name" name="name"
                                placeholder="Enter Contact Name...">
                            <span class="text-danger"></span>
                        </div>
                        <div class="form-control border-0 bg-info row d-flex justify-content-center">
                            <label for="">Network Code</label>
                            <select class=" w-50" name="code">
                                {{-- @foreach ($networks as $network)
                                    <option value="{{ $network->network_code }}"class=" w-50 ">
                                        {{ $network->network_code }}
                                    </option>
                                @endforeach --}}
                            </select>
                            <span class="text-danger"></span>
                            <div class="form-control border-0 bg-info row d-flex justify-content-center">
                                <label for="">Contact Number</label>
                                <input class="form-control w-50 " type="number" id="code" name="number"
                                    placeholder="Enter Number...">

                                <span class="text-danger"></span>
                            </div>
                        </div>

                        <button class="btn btn-dark w-50 mt-3" type="submit">Update Contact</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
