@extends('admin.layouts.app')

@section('page', 'Videos')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-12 table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Nombre</th>
                            <th scope="col">subido</th>
                            <th scope="col">Ver</th>
                            <th scope="col">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($videos as $video)
                        <tr>
                            <th scope="row">
                                @if($video->extension == 'mp4' || $video->extension == 'MP4' || $video->extension == 'vid' || $video->extension == 'VID')
                                    <img src="{{ asset('img/files/mp4.svg') }}" class="img-responsive" width="50">
                                @elseif($video->extension == 'avi' || $video->extension == 'AVI')
                                    <img src="{{ asset('img/files/avi.svg') }}" class="img-responsive" width="50">
                                @endif
                            </th>
                            <th scope="row">{{$video->name}}</th>
                            <th scope="row">{{$video->created_at->DiffForHumans()}}</th>
                            <th scope="row"><a class="btn btn-primary" target="_blank" href="{{ asset('storage') }}/{{ $folder }}/video/{{ $video->name_unique }}.{{ $video->extension }}"><i class="fas fa-eye"></i> Ver</a></th>
                            <th scope="row">
                                <button class="btn btn-danger float-right" data-toggle="modal" data-target="#deleteModal" data-file-id="{{ $video->id }}" type="submit">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                            </th>
                        </tr>
                    </tbody>

                    @empty
                        <div class="container mb-4">
                            <div class="alert alert-warning" role="alert">
                                <span class="closebtn" onclick="this.parentElement.style.display='none';">x</span>
                                <strong>Vaya</strong> Parece que aun no tienes videos
                            </div>
                        </div>
                    @endforelse
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    @include('admin.partials.modals.files')

@endsection


@section('scripts')

    @include('admin.partials.js.deleteModal')

@endsection

