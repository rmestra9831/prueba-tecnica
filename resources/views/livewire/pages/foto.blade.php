<div class="py-6 md:grid md:grid-cols-7 md:gap-8">
  <div class="md:col-span-3"> <!-- Card  Foto-->
    <h3 class="h3">Subir Foto</h3>
    <div class="bg-white overflow-hidden shadow p-4 py-6 md:grid md:grid-cols-2 md:gap-8 sm:rounded-lg">
      {{-- {{$photo}} --}}
      <div x-data="{photoName: null, photoPreview: null}" class="col-span-2 md:col-span-1 justify-content-center inherit">
        <input type="file" class="hidden"
                    wire:model="photo"
                    x-ref="photo"
                    x-on:change="
                            photoName = $refs.photo.files[0].name;
                            const reader = new FileReader();
                            reader.onload = (e) => {
                                photoPreview = e.target.result;
                            };
                            reader.readAsDataURL($refs.photo.files[0]);
                    " />

        <x-jet-label class="text-center" for="photo" value="{{ __('Photo') }}" />
        <!-- Current Profile Photo -->
        <div class="my-3" x-show="! photoPreview">
          @if ($photo)
            <img src="{{ $photo->temporaryUrl() }}" alt="" class="h-20 w-auto object-cover">    
            @else
            <img @if($photoUser) src="{{asset('storage/'.$photoUser)}}" @else src="{{asset('img/photoLoad.svg')}}" @endif  alt="" class="m-auto h-20 w-auto object-cover">    
          @endif
            {{-- <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->firstName }}" class="rounded-full h-20 w-20 object-cover"> --}}
        </div>

        <!-- New Profile Photo Preview -->
        <div class="my-3" x-show="photoPreview">
            <span class="m-auto block w-40 h-40"
                  x-bind:style="'background-size: contain; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
            </span>
        </div>

        <x-jet-secondary-button class="m-auto d-flex mr-2 " type="button" x-on:click.prevent="$refs.photo.click()">
            {{ __('Selecione una foto') }}
        </x-jet-secondary-button>

        <x-jet-input-error for="photo" class="mt-2" />
      </div>
      <!-- formulario -->
      <div class="col-span-1 @error('state') is-invalid @enderror">
        <label for="state" class="block text-sm font-medium text-gray-700">Estado<strong class="text-danger">*</strong></label>
        <select id="state" wire:model.debounce.200ms="state" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
          <option value="0">Seleccionar</option>
          <option value="active">Activo</option>
          <option value="paused">Pausa</option>
        </select>
      </div>
      <div class="col-span-1 sm:col-span-2">
        <button wire:click="loadImage" class="btn btn-primary rounded-2xl w-100" type="button">Guardar</button>
      </div>
    </div>
  </div>

  <div class="md:col-span-4"> <!-- Card estados-->
    <h3 class="h3">Estados</h3>
    <div class="row bg-white overflow-hidden shadow sm:rounded-lg p-4 justify-content-center d-flex">
      @include('common.card-stats') <!-- Tarjetas de estados -->
    </div>
  </div>

  <div class=" md:col-span-7"> <!-- Mostrando galeria de imagenes -->
    <h3 class="h3">Imagenes Cargadas</h3>
    <div class="">
      <div class="row row-cols-1 row-cols-md-4 g-4">
      @if ($images)
        @foreach ($images as $item)
        <div class="col">
          <div class="card rounded-2xl img-card">
            <img src="{{asset('storage/'.$item->url)}}" class="card-img-top rounded-2xl" alt="...">
            <button wire:click="onState('{{$item->id}}','{{$item->state}}')" class="btn @if($item->state == 'paused') btn-info @else btn-warning @endif btn-info btn-image">@if($item->state == 'paused') <i class="fas fa-play"></i> @else <i class="fas fa-pause"></i> @endif </button>
            <button wire:click="deleteImage('{{$item->id}}')" class="btn btn-danger btn-image-delete"><i class="far fa-trash-alt"></i></button>
          </div>
        </div>
        @endforeach
      @else
      <div class="col">
        Sin imagenes  
      </div>
      @endif
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  window.addEventListener('created_user', event => {
    toast = 
      `<div class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="false">
        <div class="d-flex">
          <div class="toast-body row">
            <div class="col-10">
              `+event.detail.descripcion+`
            </div>
          </div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
      </div>`;
      $('.toast-container').html(toast);
      $('.toast').toast('show');
  })
</script>
