<div>

    @role(['admin','EngineeringDepartment'])

        <div class="dropdown" id="dmenu">
            <div class="dropdown-trigger">
              <button class="button {{ $class }}" aria-haspopup="true" aria-controls="dropdown-menu" onclick="toggleDropdown()">
                <span class="icon is-small"><x-carbon-add /></span>
                <span>Add Component</span>
                <span class="icon is-small"><x-carbon-chevron-down /></span>
              </button>
            </div>
            <div class="dropdown-menu" id="dropdown-menu" role="menu">
              <div class="dropdown-content">

                <a href="/products-assy/form" class="dropdown-item">
                    <span class="icon has-text-info"><x-carbon-asset /></span>
                    <span>Assembled Product</span>
                </a>

                <a href="/details/Detail/form" class="dropdown-item">
                    <span class="icon has-text-info"><x-carbon-qr-code /></span>
                    <span>Detail (Make) Part</span>
                </a>

                <a href="/buyables/form" class="dropdown-item">
                    <span class="icon has-text-info"><x-carbon-shopping-cart-arrow-down /></span>
                    <span>Buyable Part</span>
                </a>

                <a href="/details/MakeFrom/form" class="dropdown-item">
                    <span class="icon has-text-info"><x-carbon-change-catalog /></span>
                    <span>Make-From Part</span>
                </a>

                <a href="/details/Standard/form" class="dropdown-item">
                    <span class="icon has-text-info"><x-carbon-chip /></span>
                    <span>Standard Parts</span>
                </a>

                <a href="/parts-menu" class="dropdown-item">
                    <span class="icon has-text-info"><x-carbon-chemistry /></span>
                    <span>Chemical Items</span>
                </a>

              </div>
            </div>
          </div>
    @endrole
</div>


