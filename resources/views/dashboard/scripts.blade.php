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

    const image = new Image();
    image.src = '{{ asset('img/logo.png') }}';

    function color(index) {
      return COLORS[index % COLORS.length];
    }

    function transparentize(value, opacity) {
      var alpha = opacity === undefined ? 0.5 : 1 - opacity;
      return window.colorLib(value).alpha(alpha).rgbString();
    }

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
            hidden: true
          }
        ]
      };

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
          responsive: true,
          maintainAspectRatio: false,

          scales: {
            x: {
              grid: {
                display: false
              },
            },
            y: {
              ticks: {
                callback: function(value, index, values) {
                  return value.toLocaleString("pt-BR",{style:"currency", currency:"BRL"});
                }
              }
            }
          },

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
              backgroundColor: "rgb(97, 130, 87)",
              callbacks: {
                title: function(content) {
                  return '';
                },
                label: function(context) {
                  let label = context.label.substring(0, 3) || '';
                  let label2 = context.dataIndex > 0 ? window.chart01.config.data.labels[context.dataIndex - 1].substring(0, 3) : '';
                  let label3 = "--------------------------";
                  let label4 = `${label} vs ${label2}: `;
                  let label5 = `${label} vs ${label2}: `;
                  let currentMonthValue = context.parsed.y;
                  let pastMonthValue = context.dataIndex > 0 ? context.dataset.data[context.dataIndex - 1] : 0;
                  let diffMonthsValue = currentMonthValue - pastMonthValue;
                  let diffMonthPercentage = currentMonthValue / pastMonthValue - 1;

                  if (label) {
                    label += ': ';
                  }

                  if (label2) {
                    label2 += ': ';
                  }

                  if (diffMonthsValue >= 0) {
                    label4 += '+';
                  }

                  if (diffMonthPercentage >= 0) {
                    label5 += '+';
                  }

                  if (context.parsed.y !== null) {
                    label += new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(context.parsed.y);
                  }

                  if (context.dataIndex > 0) {
                    label2 += new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(context.dataset.data[context.dataIndex - 1]);
                    label4 += new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(diffMonthsValue);
                    label5 += new Intl.NumberFormat('pt-BR', { style: 'percent', minimumFractionDigits: 0, maximumFractionDigits: 2 }).format(diffMonthPercentage);
                  } else {
                    label2+= "-";
                    label4+= "-";
                    label5+= "-";
                  }

                  return [label, label2, label3, label4, label5];
                }
              }
            }
          },
        },
      };

      const ctx01 = document.getElementById('chart-01');
      window.chart01 = new Chart(ctx01, config);
    }

    function setChat02() {
      const labels = @json([
        $year - 1,
        $year
      ]);

      const data = {
        labels: labels,
        datasets: [
          {
            label: '{{ $year }}',
            data: @json([
              $sumOld,
              $sum
            ]),
            borderColor: "#005E10",
            backgroundColor: "#005E10",
          }
        ]
      };

      const config = {
        type: 'bar',
        data: data,
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            x: {
              grid: {
                display: false
              },
            },
            y: {
              display: false,
              grid: {
                display: false
              },
              ticks: {
                callback: function(value, index, values) {
                  return value.toLocaleString("pt-BR",{style:"currency", currency:"BRL"});
                }
              }
            }
          },

          plugins: {
            chartAreaBorder: {
              borderColor: 'gray',
              borderWidth: 2,
            },
            legend: {
              display: false
            },
            title: {
              display: false,
            },
            tooltip: {
              displayColors: false,
              backgroundColor: "rgb(97, 130, 87)",
              callbacks: {
                title: function(content) {
                  return '';
                },
                label: function(context) {
                  let index = context.dataIndex > 0 ? context.dataIndex - 1 : 1;
                  let label = context.label || '';
                  let label2 = window.chart02.config.data.labels[index];
                  let label3 = "--------------------------";
                  let label4 = `${label} vs ${label2}: `;
                  let label5 = `${label} vs ${label2}: `;
                  let currentMonthValue = context.parsed.y;
                  let pastMonthValue = context.dataset.data[index];
                  let diffMonthsValue = currentMonthValue - pastMonthValue;
                  let diffMonthPercentage = currentMonthValue / pastMonthValue - 1;

                  if (label) {
                    label += ': ';
                  }

                  if (label2) {
                    label2 += ': ';
                  }

                  if (diffMonthsValue >= 0) {
                    label4 += '+';
                  }

                  if (diffMonthPercentage >= 0) {
                    label5 += '+';
                  }

                  if (context.parsed.y !== null) {
                    label += new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(context.parsed.y);
                  }

                  label2 += new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(context.dataset.data[index]);
                  label4 += new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(diffMonthsValue);
                  label5 += new Intl.NumberFormat('pt-BR', { style: 'percent', minimumFractionDigits: 0, maximumFractionDigits: 2 }).format(diffMonthPercentage);

                  return [label, label2, label3, label4, label5];
                }
              }
            }
          },
        },
      };

      const ctx02 = document.getElementById('chart-02');
      window.chart02 = new Chart(ctx02, config);
    }

    function setChat03() {
      const labels = @json(array_values(months()));
      const data = {
        labels: labels,
        datasets: [
          {
            label: '{{ $year }}',
            data: @json($cumulative),
            borderColor: "#005E10",
            backgroundColor: transparentize("#005E10", 0.5),
          },
          {
            label: '{{ $year }}',
            data: @json($goals),
            borderColor: "#A2B97C",
            backgroundColor: transparentize("#A2B97C", 0.5),
            borderDash: [5, 5],
          },
        ]
      };

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
          responsive: true,
          maintainAspectRatio: false,

          scales: {
            x: {
              grid: {
                display: false
              },
            },
            y: {
              ticks: {
                callback: function(value, index, values) {
                  return value.toLocaleString("pt-BR",{style:"currency", currency:"BRL"});
                }
              }
            }
          },

          plugins: {
            legend: {
              display: false
            },
            title: {
              display: true,
              text: 'Meta vendas {{ $year }} x Real'
            },
            tooltip: {
              displayColors: false,
              backgroundColor: "rgb(97, 130, 87)",
              callbacks: {
                title: function(content) {
                  return '';
                },
                label: function(context) {
                  let label = context.label || '';
                  let label2 = context.dataIndex > 0 ? window.chart03.config.data.labels[context.dataIndex - 1] : '';
                  let label3 = "--------------------------";
                  let label4 = `${label} vs ${label2}: `;
                  let label5 = `${label} vs ${label2}: `;
                  let currentMonthValue = context.parsed.y;
                  let pastMonthValue = context.dataIndex > 0 ? context.dataset.data[context.dataIndex - 1] : 0;
                  let diffMonthsValue = currentMonthValue - pastMonthValue;
                  let diffMonthPercentage = currentMonthValue / pastMonthValue - 1;

                  if (label) {
                    label += ': ';
                  }

                  if (label2) {
                    label2 += ': ';
                  }

                  if (diffMonthsValue >= 0) {
                    label4 += '+';
                  }

                  if (diffMonthPercentage >= 0) {
                    label5 += '+';
                  }

                  if (context.parsed.y !== null) {
                    label += new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(context.parsed.y);
                  }

                  if (context.dataIndex > 0) {
                    label2 += new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(context.dataset.data[context.dataIndex - 1]);
                    label4 += new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(diffMonthsValue);
                    label5 += new Intl.NumberFormat('pt-BR', { style: 'percent', minimumFractionDigits: 0, maximumFractionDigits: 2 }).format(diffMonthPercentage);
                  } else {
                    label2+= "-";
                    label4+= "-";
                    label5+= "-";
                  }

                  return [label, label2, label3, label4, label5];
                }
              }
            }
          },
        },
      };

      const ctx03 = document.getElementById('chart-03');
      window.chart03 = new Chart(ctx03, config);
    }

    function setChat04() {
      const labels = ['Todas as Proposta', 'Proposta Aprovadas'];
      const data = {
        labels: labels,
        datasets: [
          {
            label: '{{ $year }}',
            data: @json([
              $sumTotalItems,
              $sum
            ]),
            backgroundColor: ["#A2B97C", "#005E10"],
          }
        ]
      };


      const config = {
        type: 'pie',
        data: data,
        options: {
          responsive: true,
          maintainAspectRatio: false,

          plugins: {
            tooltip: {
              displayColors: false,
              backgroundColor: "rgb(97, 130, 87)",
              callbacks: {
                title: function(content) {
                  return '';
                },
                label: function(context) {
                  let index = context.dataIndex > 0 ? context.dataIndex - 1 : 1;
                  let label = context.label || '';
                  let label2 = window.chart04.config.data.labels[index];
                  let label3 = "--------------------------";
                  let label4 = `${label} vs ${label2}: `;
                  let label5 = `${label} vs ${label2}: `;
                  let currentMonthValue = context.parsed;
                  let pastMonthValue = context.dataset.data[index];
                  let diffMonthsValue = currentMonthValue - pastMonthValue;
                  let diffMonthPercentage = currentMonthValue / pastMonthValue - 1;

                  if (label) {
                    label += ': ';
                  }

                  if (label2) {
                    label2 += ': ';
                  }

                  if (diffMonthsValue >= 0) {
                    label4 += '+';
                  }

                  if (diffMonthPercentage >= 0) {
                    label5 += '+';
                  }

                  if (context.parsed.y !== null) {
                    label += new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(context.parsed);
                  }

                  label2 += new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(context.dataset.data[index]);
                  label4 += new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(diffMonthsValue);
                  label5 += new Intl.NumberFormat('pt-BR', { style: 'percent', minimumFractionDigits: 0, maximumFractionDigits: 2 }).format(diffMonthPercentage);

                  return [label, label2, label3, label4, label5];
                }
              }
            }
          }
        },
      };

      const ctx04 = document.getElementById('chart-04');
      window.chart04 = new Chart(ctx04, config);
    }

    function setChat05() {

      const data = {
        labels: @json($segments),
        datasets: [
          {
            label: 'Quantidade',
            data: @json($segmentsValues),
            borderColor: "#4F81BD",
            backgroundColor: "#4F81BD",
            borderWidth: 1
          }
        ]
      };

      const config = {
        type: 'bar',
        data: data,
        options: {
          indexAxis: 'y',
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            x: {
              beginAtZero: true,
              ticks: {
                precision: 0
            }
            },
            y: {
              grid: {
                display: false
              },
            }
          },

          plugins: {
            chartAreaBorder: {
              borderColor: 'gray',
              borderWidth: 2,
            },
            legend: {
              display: true
            },
            title: {
              display: true,
            },
            tooltip: {
              displayColors: false,
              backgroundColor: "rgb(97, 130, 87)",
              callbacks: {
                title: function (content) {
                  return '';
                },
                label: function (context) {
                  let label = context.label || '';
                  let currentValue = context.parsed.x;
                  let total = window.chart05.config.data.datasets[0].data.reduce((sum, value) => sum + value, 0);
                  let diffPercentage = currentValue / total;
                  let label2 = '';

                  label += ": " + currentValue;
                  label2 += new Intl.NumberFormat('pt-BR', { style: 'percent', minimumFractionDigits: 0, maximumFractionDigits: 2 }).format(diffPercentage);;

                  return [label, label2];
                }
              }
            }
          },
        },
      };

      const ctx05 = document.getElementById('chart-05');
      window.chart05 = new Chart(ctx05, config);
    }

    function setChat06() {

      const data = {
        labels: @json($products),
        datasets: [
          {
            label: 'Quantidade',
            data: @json($productsValues),
            borderColor: "#4F81BD",
            backgroundColor: "#4F81BD",
            borderWidth: 1
          }
        ]
      };

      const config = {
        type: 'bar',
        data: data,
        options: {
          indexAxis: 'y',
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            x: {
              beginAtZero: true,
              ticks: {
                precision: 0
            }
            },
            y: {
              grid: {
                display: false
              },
            }
          },

          plugins: {
            chartAreaBorder: {
              borderColor: 'gray',
              borderWidth: 2,
            },
            legend: {
              display: true
            },
            title: {
              display: true,
            },
            tooltip: {
              displayColors: false,
              backgroundColor: "rgb(97, 130, 87)",
              callbacks: {
                title: function (content) {
                  return '';
                },
                label: function (context) {
                  let label = context.label || '';
                  let currentValue = context.parsed.x;
                  let total = window.chart06.config.data.datasets[0].data.reduce((sum, value) => sum + value, 0);
                  let diffPercentage = currentValue / total;
                  let label2 = '';

                  label += ": " + currentValue;
                  label2 += new Intl.NumberFormat('pt-BR', { style: 'percent', minimumFractionDigits: 0, maximumFractionDigits: 2 }).format(diffPercentage);;

                  return [label, label2];
                }
              }
            }
          },
        },
      };

      const ctx06 = document.getElementById('chart-06');
      window.chart06 = new Chart(ctx06, config);
    }

    setChat01();
    setChat02();
    setChat03();
    setChat04();
    setChat05();
    setChat06();

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

    function filterChart02() {
      let ajax = new XMLHttpRequest();
      let token = document.querySelector('meta[name="csrf-token"]').content;
      let method = 'POST';
      let year = document.querySelector(`#year`).value;
      let department_id = document.querySelector(`#department_id`).value;
      let direction_id = document.querySelector(`#direction_id`).value;
      let url = "{{ route('dashboard.filter-chart02') }}";

      ajax.open(method, url);

      ajax.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var resp = JSON.parse(ajax.response);

          window.chart02.data.labels.splice(0,  window.chart02.data.labels.length);

          window.chart02.data.datasets.forEach((dataset) => {
            dataset.data.splice(0,  dataset.data.length);
            dataset.label = "";
          });

          window.chart02.update();

          const sum = resp.sum;
          const sumOld = resp.sumOld;

          window.chart02.data.datasets[0].data.push(sumOld);
          window.chart02.data.datasets[0].data.push(sum);
          window.chart02.data.datasets[0].label = resp.year

          window.chart02.data.labels.push(resp.year - 1);
          window.chart02.data.labels.push(resp.year);

          window.chart02.update();

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

    function filterChart03() {
      let ajax = new XMLHttpRequest();
      let token = document.querySelector('meta[name="csrf-token"]').content;
      let method = 'POST';
      let year = document.querySelector(`#year`).value;
      let department_id = document.querySelector(`#department_id`).value;
      let direction_id = document.querySelector(`#direction_id`).value;
      let url = "{{ route('dashboard.filter-chart03') }}";

      ajax.open(method, url);

      ajax.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          var resp = JSON.parse(ajax.response);

          window.chart03.data.datasets.forEach((dataset) => {
            dataset.data.splice(0, dataset.data.length);
            dataset.label = "";
          });

          window.chart03.update();

          const cumulative = resp.cumulative;
          const goals = resp.goals;
          Object.keys(cumulative).forEach(key => {
            window.chart03.data.datasets[0].data.push(cumulative[key]);
            window.chart03.data.datasets[0].label = resp.year
          });

          Object.keys(goals).forEach(key => {
            window.chart03.data.datasets[1].data.push(goals[key]);
            window.chart03.data.datasets[1].label = resp.year - 1
          });

          window.chart03.update();

        } else if (this.readyState == 4 && this.status != 200) {
          toastr.error("{!! __('Um erro ocorreu ao solicitar a consulta') !!}");
          that.value = '';
        }
      }

      var data = new FormData();
      data.append('_token', token);
      data.append('_method', method);
      if (year) data.append('year', year);
      if (department_id) data.append('department_id', department_id);
      if (direction_id) data.append('direction_id', direction_id);

      ajax.send(data);
    }

    function filterchart04() {
      let ajax = new XMLHttpRequest();
      let token = document.querySelector('meta[name="csrf-token"]').content;
      let method = 'POST';
      let year = document.querySelector(`#year`).value;
      let department_id = document.querySelector(`#department_id`).value;
      let direction_id = document.querySelector(`#direction_id`).value;
      let url = "{{ route('dashboard.filter-chart04') }}";

      ajax.open(method, url);

      ajax.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var resp = JSON.parse(ajax.response);

          window.chart04.data.datasets.forEach((dataset) => {
            dataset.data.splice(0,  dataset.data.length);
          });

          window.chart04.update();

          const sum = resp.sum;
          const sumTotalItems = resp.sumTotalItems;

          window.chart04.data.datasets[0].data.push(sumTotalItems);
          window.chart04.data.datasets[0].data.push(sum);
          window.chart04.data.datasets[0].label = resp.year

          window.chart04.update();

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

    function filterchart05() {
      let ajax = new XMLHttpRequest();
      let token = document.querySelector('meta[name="csrf-token"]').content;
      let method = 'POST';
      let region = document.querySelector(`#region`).value;
      let state = document.querySelector(`#state`).value;
      let city = document.querySelector(`#city`).value;
      let url = "{{ route('dashboard.filter-chart05') }}";

      ajax.open(method, url);

      ajax.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          var resp = JSON.parse(ajax.response);

          window.chart05.data.datasets.forEach((dataset) => {
            dataset.data.splice(0, dataset.data.length);
          });

          window.chart05.data.labels.splice(0, window.chart05.data.labels.length);

          window.chart05.update();

          const segments = resp.segments;
          const values = resp.values;

          Object.keys(values).forEach(key => {
            window.chart05.data.datasets[0].data.push(values[key]);
          });

          Object.keys(segments).forEach(key => {
            window.chart05.data.labels.push(segments[key]);
          });

          window.chart05.update();

        } else if (this.readyState == 4 && this.status != 200) {
          toastr.error("{!! __('Um erro ocorreu ao solicitar a consulta') !!}");
          that.value = '';
        }
      }

      var data = new FormData();
      data.append('_token', token);
      data.append('_method', method);
      if(region) data.append('region', region);
      if(state) data.append('state', state);
      if(city) data.append('city', city);

      ajax.send(data);
    }

    function filterchart06() {
      let ajax = new XMLHttpRequest();
      let token = document.querySelector('meta[name="csrf-token"]').content;
      let method = 'POST';
      let year = document.querySelector(`#year`).value;
      let department_id = document.querySelector(`#department_id`).value;
      let direction_id = document.querySelector(`#direction_id`).value;
      let url = "{{ route('dashboard.filter-chart06') }}";

      ajax.open(method, url);

      ajax.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          var resp = JSON.parse(ajax.response);

          window.chart06.data.datasets.forEach((dataset) => {
            dataset.data.splice(0, dataset.data.length);
          });

          window.chart06.data.labels.splice(0, window.chart06.data.labels.length);

          window.chart06.update();

          const products = resp.products;
          const values = resp.values;

          Object.keys(values).forEach(key => {
            window.chart06.data.datasets[0].data.push(values[key]);
          });

          Object.keys(products).forEach(key => {
            window.chart06.data.labels.push(products[key]);
          });

          window.chart06.update();

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

    function getCities(state) {
      const dataForm = new FormData();
      const token = document.querySelector('meta[name="csrf-token"]').content;
      const city = document.querySelector("#city");

      dataForm.append("_method", "POST");
      dataForm.append("_token", token);

      fetch("{{ route('customers.address.cities', ['state' => '#']) }}".replace("#", state), {
        method: 'POST',
        body: dataForm
      })
      .then(res => res.text())
      .then(data => {
        const response = JSON.parse(data);

        var i, L = city.options.length - 1;
        for (i = L; i >= 0; i--) {
            city.remove(i);
        }

        for (let index = 0; index < response.length; index++) {
          const element = response[index];
          var option = document.createElement("option");
          option.text = element['municipio-nome'];
          option.value = element['municipio-nome'];

          city.add(option);
        }

        window.customSelectArray["city"].update();
      }).catch(err => {
          console.log(err);
      });
    }

    document.querySelectorAll("#year, #department_id, #direction_id").forEach(item => {
      item.addEventListener("change", function() {
        filterChart01();
        filterChart02();
        filterChart03();
        filterchart04();
        filterchart06();
      });
    });

    document.querySelectorAll("#region, #state, #city").forEach(item => {
      item.addEventListener("change", function() {
        filterchart05();
        if(this.id == 'state') {
          //getCities(this.value);
        }
      });
    });
  });


</script>
