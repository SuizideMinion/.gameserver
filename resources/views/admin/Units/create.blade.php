@extends('layout.admin')

@section('content')
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Horizontal Form</h5>

                    <!-- Horizontal Form -->
                    <form method="post" action="{{ route('admin.buildings.store') }}">
                        @csrf
                        <div class="row mb-3">
                            <label for="desc" class="col-sm-2 col-form-label">Description:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="desc" name="desc">
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form><!-- End Horizontal Form -->

                </div>
            </div>

        </div>
    </div>
@endsection
