

<section class="section container">

    <script>



    function toggleDropdown() {

        let dd = document.getElementById('dmenu')
      
        if (dd.classList.contains('is-active')) {
            dd.classList.remove('is-active')
        } else {
            dd.classList.add('is-active')
        }
      
        //console.log(event.target)
      }
      

    </script>



    <header class="mb-6">

    

            <h1 class="title has-text-weight-light is-size-1">Buyable Parts</h1>
            <h2 class="subtitle has-text-weight-light">Buyable Part Properties</h2>


    </header>





    <nav class="level">
        <!-- Left side -->
        <div class="level-left">





          <div class="level-item">
            <button class="button">
                <span class="icon is-small">
                  <x-carbon-show-data-cards />
                </span>
              </button>
          </div>
          <div class="level-item">
            <button class="button">
                <span class="icon is-small">
                  <x-carbon-show-data-cards />
                </span>
                <span>List All</span>
              </button>
          </div>
        </div>
      
        <!-- Right side -->
        <div class="level-right">



            <button class="button level-item">
              <span class="icon is-small">
                <x-carbon-edit /></span>
              </span>
            </button>

            <button class="button  level-item has-background-danger">
              <span class="icon is-small has-text-white">
                <x-carbon-trash-can />
              </span>
            </button>



          <div class="dropdown level-item ml-6" id='dmenu'>

            <div class="dropdown-trigger is-pulled-left">
              <button class="button" aria-haspopup="true" aria-controls="dropdown-menu3" onclick='toggleDropdown()'>
                <span class="icon is-small">
                    <x-carbon-overflow-menu-vertical />
                </span>
              </button>
            </div>
            <div class="dropdown-menu" id="dropdown-menu3" role="menu">
              <div class="dropdown-content">

                <a href="#" class="dropdown-item">
                    <span class="icon is-small">
                        <x-carbon-overflow-menu-vertical />
                    </span>
                    <span>Freeze Item</span>           
                </a>


                <a href="#" class="dropdown-item">
                    <span class="icon ">
                        <x-carbon-pdf />
                    </span>
                    <span>Release Item</span>           
                </a>



                <a href="#" class="dropdown-item"> Release Item </a>
                <a href="#" class="dropdown-item"> BOM to PDF </a>
                <a href="#" class="dropdown-item"> Replicate Item </a>
                <a href="#" class="dropdown-item"> Make Mirror </a>
                <hr class="dropdown-divider" />
                <a href="#" class="dropdown-item"> More </a>
              </div>
            </div>
          </div>














        </div>
      </nav>































<div class="card has-background-white p-6">



<div class="fixed-grid has-4-cols">
    <div class="grid">
      <div class="cell  has-background-link ">Cell 1</div>
      <div class="cell is-col-span-2  has-background-info ">Cell 2</div>
      <div class="cell has-background-danger   ">Cell 3</div>
      <div class="cell  has-background-success ">Cell 4</div>
      <div class="cell has-background-warning ">Cell 5</div>
      <div class="cell has-background-info ">Cell 6</div>
    </div>
</div>

</div>
</section>