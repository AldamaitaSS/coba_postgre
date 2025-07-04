<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{{ $breadcrumb->title }}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('admin/') }}">Home</a></li>
            @foreach ($breadcrumb->list as $key => $value)
                @php
                    $name = is_array($value) ? $value['name'] : $value;
                @endphp

                @if (strtolower($name) != 'home')
                    <li class="breadcrumb-item">
                        {{ htmlspecialchars($name) }}
                    </li>
                @endif
            @endforeach
          </ol>
        </div>
      </div>
    </div>
</section>
