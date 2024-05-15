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
        <div>
          <canvas id="myChart"></canvas>
        </div>
      </div>
    </div>
  </div>

  <script>
    window.addEventListener("load", function() {
      const DATA_COUNT = 7;
      const NUMBER_CFG = {count: DATA_COUNT, min: -100, max: 100};

      const MONTHS = @json(array_values(months()));

      function months(config) {
        var cfg = config || {};
        var count = cfg.count || 12;
        var section = cfg.section;
        var values = [];
        var i, value;

        for (i = 0; i < count; ++i) {
          value = MONTHS[Math.ceil(i) % 12];
          values.push(value.substring(0, section));
        }

        return values;
      }

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

      var _seed = Date.now();

      function srand(seed) {
        _seed = seed;
      }

      function rand(min, max) {
        min = window.Helper.valueOrDefault(min, 0);
        max = window.Helper.valueOrDefault(max, 0);
        _seed = (_seed * 9301 + 49297) % 233280;
        return min + (_seed / 233280) * (max - min);
      }

      function numbers(config) {
        var cfg = config || {};
        var min = window.Helper.valueOrDefault(cfg.min, 0);
        var max = window.Helper.valueOrDefault(cfg.max, 100);
        var from = window.Helper.valueOrDefault(cfg.from, []);
        var count = window.Helper.valueOrDefault(cfg.count, 8);
        var decimals = window.Helper.valueOrDefault(cfg.decimals, 8);
        var continuity = window.Helper.valueOrDefault(cfg.continuity, 1);
        var dfactor = Math.pow(10, decimals) || 0;
        var data = [];
        var i, value;

        for (i = 0; i < count; ++i) {
          value = (from[i] || 0) + rand(min, max);
          if (rand() <= continuity) {
            data.push(Math.round(dfactor * value) / dfactor);
          } else {
            data.push(null);
          }
        }

        return data;
      }

      const labels = months({count: 12});
      const data = {
        labels: labels,
        datasets: [
          {
            label: '{{ $year }}',
            data: @json($items),
            borderColor: CHART_COLORS.blue,
            backgroundColor: transparentize(CHART_COLORS.blue, 0.5),
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

      const config = {
        type: 'line',
        data: data,
        options: {
          responsive: true,
          plugins: {
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
                  let label2 = window.chatTeste.config.data.datasets[1].label || '';

                  if (label) {
                    label += ': ';
                  }

                  if (label2) {
                    label2 += ': ';
                  }

                  if (context.parsed.y !== null) {
                    label += new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(context.parsed.y);
                  }

                  if (window.chatTeste.config.data.datasets[1].data[context.dataIndex]) {
                    label2 += new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(window.chatTeste.config.data.datasets[1].data[context.dataIndex]);
                  } else {
                    label2+= "-"
                  }

                  return [label, label2];
                }
              }
            }
          }
        },
      };

      const ctx = document.getElementById('myChart');

      window.chatTeste = new Chart(ctx, config);




    });

  </script>
</x-app-layout>
