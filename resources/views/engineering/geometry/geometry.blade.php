<section class="section container">

  <nav class="breadcrumb has-bullet-separator mb-5" aria-label="breadcrumbs">
      <ul>
        <li><a href='/engineering/home'>Engineering</a></li>
        <li class="is-active"><a href="#" aria-current="page">Geometry</a></li>
      </ul>
  </nav>

  <header class="mb-6">
      <h1 class="title has-text-weight-light is-size-1">Engineering Utilities : Geometry</h1>
      <h2 class="subtitle has-text-weight-light">Geometric Properties of General Sections</h2>
  </header>


  <div class="columns">



    <div class="column">
        <a href="/engineering/geometry/circle" class="has-text-centered is-block">Circular Sections</a>

        <a href="/engineering/geometry/circle">

        <figure class="image">
          <img src="{{ asset('/images/Circle.svg') }}">
        </figure>
        </a>
      </div>








    <div class="column">

      <a wire:click="selectAction('geometry-circle')" class="has-text-centered is-block">Circle</a>


      <a wire:click="selectAction('geometry-circle')">
        <figure class="image">
          <img src="{{ asset('/images/Circle.svg') }}">
        </figure>
      </a>

    </div>

    <div class="column">
      <a wire:click="selectAction('geometry-rectangle')" class="has-text-centered is-block">Rectangle</a>

      <a wire:click="selectAction('geometry-rectangle')">

      <figure class="image">
        <img src="{{ asset('/images/Rectangle.svg') }}">
      </figure>
      </a>
    </div>


    <div class="column">
      <a href="/engineering/geometry/lshape" class="has-text-centered is-block">L-Shaped Sections</a>

      <a href="/engineering/geometry/lshape">

      <figure class="image">
        <img src="{{ asset('/images/Lshape.svg') }}">
      </figure>
      </a>
    </div>







  </div>


</section>
