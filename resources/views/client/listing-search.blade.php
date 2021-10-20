@extends('client.layouts.app')
@section('meta')
    <title>Private Chartered Jets & Planes | JetOnset</title>
    <meta name="description" content="Find out how it works here at JetOnset and see our fleet of private chartered jets and planes!">
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <table class="table table-hover">

                    <tbody>
                    <tr>
                        <td class="col-sm-8 col-md-5">
                            <div class="media">
                                <div class="media-body">
                                    <span class="media-heading"><a href="#">Product name</a></span>
                                    <span class="media-heading"> by <a href="#">Brand name</a></span>
                                    <span>Status: </span><span class="text-success"><strong>In Stock</strong></span>
                                </div>
                            </div>
                        </td>

                        <td class="col-sm-1 col-md-4 text-center"><strong>$4.87</strong></td>
                        <td class="col-sm-1 col-md-3">
                            <button type="button" class="btn btn-danger">
                                <span class="glyphicon glyphicon-remove"></span> Remove
                            </button>
                        </td>
                    </tr>


                    </tbody>
                </table>
            </div>
        </div>
    </div>


@endsection
