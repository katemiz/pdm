<x-pdm-layout title="Products Menu">

    <script>

        let selected = 'A'

        let options = [
            {
                'id' : 'assy',
                'title' : 'Assembly',
                'icon' : '<x-carbon-asset />',
                'header':'Assembled Products',
                'explanation':'For products which are assembled and containes more than one part',
                'route':'/products-assy/form',
                'button_text':'Add Assembly Product'
            },

            {
                'id' : 'buyable',
                'title' : 'Buyable Parts',
                'icon' : '<x-carbon-shopping-cart-arrow-down />',
                'header':'Buyable Products',
                'explanation':'For products that are bought from other vendors. Equipments.',
                'route':'/buyables/form',
                'button_text':'Add Buyable Product'
            },

            {
                'id' : 'detail',
                'title' : 'Detail Part',
                'icon' : '<x-carbon-qr-code />',
                'header':'Detail (Single) Parts',
                'explanation':'For products that are bought from other vendors. Equipments.',
                'route':'/details/form',
                'button_text':'Add Single Part'
            },

            {
                'id' : 'makefrom',
                'title' : 'Make From Part',
                'icon' : '<x-carbon-change-catalog />',
                'header':'Make From Parts',
                'explanation':'For products that are bought from other vendors. Equipments.',
                'route':'/products-add',
                'button_text':'Add Make From Product'
            },

            {
                'id' : 'standard',
                'title' : 'Standard Parts',
                'icon' : '<x-carbon-catalog />',
                'header':'Standard Parts',
                'explanation':'For products that are bought from other vendors. Equipments.',
                'route':'/products-add',
                'button_text':'Add Standard Part'
            },

            {
                'id' : 'chemical',
                'title' : 'Chemical Items',
                'icon' : '<x-carbon-chemistry />',
                'header':'Chemical Items',
                'explanation':'For products that are bought from other vendors. Equipments.',
                'route':'/products-add',
                'button_text':'Add Chemical Item'
            },
        ]

        let active_el_id = options[0].id;



        function initialize() {

            let ul = document.getElementById('ul')

            options.forEach(element => {

                let li = document.createElement('li')
                li.id = 'li'+element.id

                if (element.id == active_el_id) {
                    li.classList.add('is-active')

                    document.getElementById('exp_header').innerHTML = element.header
                    document.getElementById('explanation').innerHTML = element.explanation

                    document.getElementById('route').href = element.route
                    document.getElementById('link_button').innerHTML = element.button_text

                    document.getElementById('media_icon').innerHTML = element.icon
                }

                let a = document.createElement('a')

                a.href = "javascript:makeActive('"+element.id+"')";


                let span1 = document.createElement('span')
                span1.classList.add('icon','is-small')
                span1.innerHTML = element.icon
                span1.addEventListener("click", makeActive, true);

                let span2 = document.createElement('span')
                span2.innerHTML = element.title


                li.append(a)
                a.append(span1)
                a.append(span2)

                ul.append(li)
            });

        }


        function makeActive(id){

            let li

            options.forEach(element => {

                li = document.getElementById('li'+element.id).classList.remove('is-active','has-background-danger')

                if (id == element.id) {

                    document.getElementById('li'+id).classList.add('is-active')

                    document.getElementById('exp_header').innerHTML = element.header
                    document.getElementById('explanation').innerHTML = element.explanation

                    document.getElementById('route').href = element.route
                    document.getElementById('link_button').innerHTML = element.button_text

                    document.getElementById('media_icon').innerHTML = element.icon
                }

            })



        }


    </script>

    <section class="section container has-background-white">


        <h1 class="title">dfjgıfdjgıfdg</h1>


        <p class="title has-text-weight-light is-size-1">Products</p>
        <p class="subtitle is-size-4">Products Menu - Select Type of Product</p>

        <div class="tabs is-centered is-boxed">
            <ul id="ul"></ul>
        </div>

        <div class="card">
        <div class="card-content">
            <div class="media">
              <div class="media-left">
                <figure class="image is-128x128 has-text-info" id="media_icon"></figure>
              </div>
              <div class="media-content">
                <p id="exp_header" class="title is-4"></p>
                <p id="explanation" class="subtitle is-6"></p>
              </div>
            </div>

            <div class="content has-text-right">
                <a id="route" href="" class="button is-dark">
                    <span class="icon is-small"><x-carbon-add /></span>
                    <span id="link_button"></span>
                </a>
            </div>
        </div>
        </div>

    </section>

    <script>
        initialize()
    </script>

</x-pdm-layout>
