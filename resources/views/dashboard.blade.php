<x-app-layout>
  <div class="py-6 dashboard">
    <div class="md:max-w-6xl lg:max-w-full mx-auto px-4">
      <div class="flex md:flex-row flex-col">
        <div class="w-full flex items-center">
          <h1>{{ __('Dashboard') }}</h1>
        </div>
        <div class="w-full flex justify-end">
          <div class="m-2 ">
            <a href="{{ route('customers.conversations.item.faster-create') }}" class="btn-outline-success">{{ __('Nova
              Interação') }}</a>
          </div>
        </div>
      </div>
      <div class="py-2 my-2 bg-white rounded-lg">
        <div class="w-full flex justify-end">
          <div class="w-full md:w-1/6 px-2 mb-6 md:mb-0">
            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="year">
              {{ __('Ano') }}
            </label>
            <x-custom-select class="mt-1" :options="$years" name="year" id="year"
              :value="app('request')->input('year')" />
          </div>
          <div class="w-full md:w-1/4 px-2 mb-6 md:mb-0">
            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="department_id">
              {{ __('Departamento') }}
            </label>
            <x-custom-select class="mt-1" :options="$departments" name="department_id" id="department_id"
              :value="app('request')->input('department_id')" />
          </div>
          <div class="w-full md:w-1/4 px-2 mb-6 md:mb-0">
            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="direction_id">
              {{ __('Diretoria') }}
            </label>
            <x-custom-select class="mt-1" :options="$directions" name="direction_id" id="direction_id"
              :value="app('request')->input('direction_id')" />
          </div>
        </div>
        <div class="w-1/2 p-4 my-2">
          <canvas id="chart-01" style="border: 2px solid #ccc; padding: 5px;"></canvas>
        </div>
      </div>
    </div>
  </div>

  <script>
    window.addEventListener("load", function() {

      const CHART_COLORS = {
        red: 'rgb(255, 99, 132)',
        orange: 'rgb(255, 159, 64)',
        yellow: 'rgb(255, 205, 86)',
        green: 'rgb(75, 192, 192)',
        blue: 'rgb(54, 162, 235)',
        purple: 'rgb(153, 102, 255)',
        grey: 'rgb(201, 203, 207)'
      };

      const NAMED_COLORS = [
        CHART_COLORS.red,
        CHART_COLORS.orange,
        CHART_COLORS.yellow,
        CHART_COLORS.green,
        CHART_COLORS.blue,
        CHART_COLORS.purple,
        CHART_COLORS.grey,
      ];

      function namedColor(index) {
        return NAMED_COLORS[index % NAMED_COLORS.length];
      }

      const COLORS = [
        '#4dc9f6',
        '#f67019',
        '#f53794',
        '#537bc4',
        '#acc236',
        '#166a8f',
        '#00a950',
        '#58595b',
        '#8549ba'
      ];

      function color(index) {
        return COLORS[index % COLORS.length];
      }

      function transparentize(value, opacity) {
        var alpha = opacity === undefined ? 0.5 : 1 - opacity;
        return window.colorLib(value).alpha(alpha).rgbString();
      }

      setChat01();

      function setChat01() {
        const labels = @json(array_values(months()));
        const data = {
          labels: labels,
          datasets: [
            {
              label: '{{ $year }}',
              data: @json($items),
              borderColor: "#005E10",
              backgroundColor: transparentize("#005E10", 0.5),
            },
            {
              label: '{{ $year - 1 }}',
              data: @json($itemsOld),
              borderColor: CHART_COLORS.red,
              backgroundColor: transparentize(CHART_COLORS.red, 0.5),
              hidden: true
            }
          ]
        };

        const image = new Image();
        image.src = '{{ asset('img/logo.png') }}';

        const config = {
          type: 'line',
          data: data,
          plugins: [{
            id: 'customCanvasBackgroundImage',
            beforeDraw: (chart) => {
              if (image.complete) {
                const ctx = chart.ctx;
                const {top, left, width, height} = chart.chartArea;
                const x = left + width / 2 - image.width / 2;
                const y = top + height / 2 - image.height / 2;
                ctx.drawImage(image, x, y);
              } else {
                image.onload = () => chart.draw();
              }
            }
          }],
          options: {
            scales: {
              x: {
                grid: {
                  display: false
                }
              },
            },
            responsive: true,
            plugins: {
              chartAreaBorder: {
                borderColor: 'gray',
                borderWidth: 2,
              },
              legend: {
                display: false
              },
              title: {
                display: true,
                text: 'Vendas {{ $year }} - R$ {{ number_format($sum, 2, ",", ".") }}'
              },
              tooltip: {
                displayColors: false,
                callbacks: {
                  label: function(context) {
                    let label = context.dataset.label || '';
                    let label2 = window.chart01.config.data.datasets[1].label || '';

                    if (label) {
                      label += ': ';
                    }

                    if (label2) {
                      label2 += ': ';
                    }

                    if (context.parsed.y !== null) {
                      label += new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(context.parsed.y);
                    }

                    if (window.chart01.config.data.datasets[1].data[context.dataIndex]) {
                      label2 += new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(window.chart01.config.data.datasets[1].data[context.dataIndex]);
                    } else {
                      label2+= "-"
                    }

                    return [label, label2];
                  }
                }
              }
            },
          },
        };

        const ctx = document.getElementById('chart-01');

        window.chart01 = new Chart(ctx, config);
      }

      function filterChart01() {
        let ajax = new XMLHttpRequest();
        let token = document.querySelector('meta[name="csrf-token"]').content;
        let method = 'POST';
        let year = document.querySelector(`#year`).value;
        let department_id = document.querySelector(`#department_id`).value;
        let direction_id = document.querySelector(`#direction_id`).value;
        let url = "{{ route('dashboard.filter-chart01') }}";

        ajax.open(method, url);

        ajax.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            var resp = JSON.parse(ajax.response);

            window.chart01.data.datasets.forEach((dataset) => {
              dataset.data.splice(0,  dataset.data.length);
              dataset.label = "";
            });

            window.chart01.update();

            const items = resp.items;
            const itemsOld = resp.itemOlds;
            Object.keys(items).forEach(key => {
              window.chart01.data.datasets[0].data.push(items[key]);
              window.chart01.data.datasets[0].label = resp.year
            });

            Object.keys(itemsOld).forEach(key => {
              window.chart01.data.datasets[1].data.push(itemsOld[key]);
              window.chart01.data.datasets[1].label = resp.year - 1
            });

            window.chart01.options.plugins.title.text = `Vendas ${resp.year} - R$ ${new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(resp.sum)}`;

            window.chart01.update();

          } else if (this.readyState == 4 && this.status != 200) {
            toastr.error("{!! __('Um erro ocorreu ao solicitar a consulta') !!}");
            that.value = '';
          }
        }

        var data = new FormData();
        data.append('_token', token);
        data.append('_method', method);
        if(year) data.append('year', year);
        if(department_id) data.append('department_id', department_id);
        if(direction_id) data.append('direction_id', direction_id);

        ajax.send(data);
      }

      document.querySelectorAll("#year, #department_id, #direction_id").forEach(item => {
        item.addEventListener("change", function() {
          filterChart01();
        });
      });

    });

  </script>
</x-app-layout>
