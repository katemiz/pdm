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

    <div class="tile is-ancestor">
      <div class="tile is-vertical">
        <div class="tile">
          <div class="tile is-parent is-vertical">
            <div class="card" >
              <div class="card-image">
                <figure class="image">
                  <img src="{{ asset('/images/Circle.svg') }}">
                </figure>
              </div>
      
              <div class="card-content">
                <div class="content">
                  <a wire:click="selectAction('geometry-circle')">Circle</a>
                </div>
              </div>
            </div>
          </div>
          <div class="tile is-parent">
            <div class="card" >
              <div class="card-image">
                <figure class="image">
                  <img src="{{ asset('/images/Rectangle.svg') }}">
                </figure>
              </div>
      
              <div class="card-content">
                <div class="content">
                  <a wire:click="selectAction('geometry-rectangle')">Rectangle</a>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>
</section>
