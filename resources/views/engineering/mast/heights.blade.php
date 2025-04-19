<section class="section container">

    <nav class="breadcrumb has-bullet-separator mb-5" aria-label="breadcrumbs">
        <ul>
          <li><a href='/engineering/home'>Engineering</a></li>
          <li class="is-active"><a href="#" aria-current="page">Mast Nested/Extended Heights</a></li>
        </ul>
    </nav>

    <header class="mb-6">
        <h1 class="title has-text-weight-light is-size-1">No of Sections - Extended Height - Nested Height</h1>
        <h2 class="subtitle has-text-weight-light">Relationship between three parameters</h2>
    </header>


    <div class="card p-6">

        <div class="columns">

            <div class="column field is-half">
                <label class="label">Number of Sections</label>
                <div class="control">
                <input class="input" type="number" placeholder="Number of Sections" wire:model.live="NoOfSections" min="2"  max="15">
                </div>
            </div>


            <div class="column field">
                <label class="label">Length of Sections (mm)</label>
                <div class="control">
                <input class="input" type="text" placeholder="Tube Lengths" wire:model.live="LengthOfSections" >
                </div>
            </div>

        </div>


        <div class="columns">


            <div class="column field is-half">
                <label class="label">Overlap Length (mm)</label>
                <div class="control">
                <input class="input" type="text" placeholder="Overlap Length" wire:model.live="OverlapOfSections" >
                </div>
            </div>


            <div class="column field">
                <label class="label">Head Distance (mm)</label>
                <div class="control">
                <input class="input" type="text" placeholder="Head Distance" wire:model.live="HeadOfSections" >
                </div>
            </div>

        </div>

    </div>


    <div class="card has-background-grey-lighter p-6">

        <nav class="level">
            <div class="level-item has-text-centered">
              <div>
                <p class="heading">Extended Height</p>
                <p class="title" >{{ $extendedHeight }}</p>
                <p class="heading">mm</p>

              </div>
            </div>
            <div class="level-item has-text-centered">
              <div>
                <p class="heading">Nested Height</p>
                <p class="title" >{{ $nestedHeight }}</p>
                <p class="heading">mm</p>

              </div>
            </div>

          </nav>


    </div>

</section>