<div class="container">
    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 sm:items-center py-4 sm:pt-0">
        @if (Route::has('login'))
            <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block btn-actions-log w-100 bg-grey-300 d-flex bg-white" style="justify-content: flex-end; z-index: 10;">
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 underline text-decoration-none">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-700">Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 font-weight-bold">Registro</a>
                    @endif
                @endauth
            </div>
        @endif

        <div class="row mt-5 pt-3">
            <div class="max-w-6xl mx-auto lg:px-8 d-flex justify-content-center mt-3 border-b-2"><h1>Galeria</h1></div>
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 h-100"> <!-- galeria de fotos -->
                <div class="row row-cols-1 row-cols-md-4 g-4 mt-2">
                    @foreach ($photos as $item)
                        @if ($item->state == 'active')
                            <div class="col">
                                <div class="card">
                                  <img src="{{asset('storage/'.$item->url)}}" class="card-img-top" alt="...">
                                  {{-- <div class="card-body">
                                      ds
                                  </div> --}}
                                  <div class="card-footer">
                                      <small class="text-muted text-capitalize">Autor: {{$item->user->name}}</small>
                                    </div>
                                </div>
                            </div>  
                        @endif  
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
