// (function($) {
  // 'use strict';

  $(function() {
    $.ajax({
        url: 'src/pages/admin/controller/data-pendapatan.php',
        type: 'GET',
        success: function(data) {
            try {
                console.log('Data received:', data);
                renderChart_pendapatan(data);
            } catch (error) {
                console.error('Error handling data:', error);
                console.error('Response received:', data);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX error:', status, error);
            console.error('Response text:', xhr.responseText);
        }
    });

    function renderChart_pendapatan(data) {
        console.log('Data to render:', data);
        const labels = data.map(row => row.tanggal_pesanan);
        const dataset = data.map(row => row.total_harga);
        console.log('Labels:', labels);
        console.log('Dataset:', dataset);

        if ($("#performanceLine").length) {
            const ctx = document.getElementById('performanceLine');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Pendapatan',
                        data: dataset,
                        backgroundColor: 'rgba(26, 115, 232, 0.18)',
                        borderColor: '#1F3BB3',
                        borderWidth: 1.5,
                        fill: true,
                        pointBorderWidth: 1,
                        pointRadius: 4,
                        pointHoverRadius: 2,
                        pointBackgroundColor: '#1F3BB3',
                        pointBorderColor: '#fff',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    elements: {
                        line: {
                            tension: 0.4,
                        }
                    },
                    scales: {
                        y: {
                            border: {
                                display: false
                            },
                            grid: {
                                display: true,
                                color: "#F0F0F0",
                                drawBorder: false,
                            },
                            ticks: {
                                beginAtZero: false,
                                autoSkip: true,
                                maxTicksLimit: 4,
                                color: "#6B778C",
                                font: {
                                    size: 10,
                                }
                            }
                        },
                        x: {
                            border: {
                                display: false
                            },
                            grid: {
                                display: false,
                                drawBorder: false,
                            },
                            ticks: {
                                beginAtZero: false,
                                autoSkip: true,
                                maxTicksLimit: 7,
                                color: "#6B778C",
                                font: {
                                    size: 10,
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false,
                        }
                    }
                }
            });
        }
    }

    $.ajax({
        url: 'src/pages/admin/controller/data-penjualan.php',
        type: 'GET',
        success: function(data) {
            console.log('Response received:', data);
            try {
                renderChart_penjualan(data);
            } catch (error) {
                console.error('Error processing data:', error);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX error:', status, error);
        }
    });

    function renderChart_penjualan(data) {
        if ($("#data-penjualan").length) {
            const ctx = document.getElementById('data-penjualan');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.map(row => row.tanggal_pesanan),
                    datasets: [{
                        label: 'Jumlah',
                        data: data.map(row => row.jumlah),
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1.5,
                        fill: true,
                        pointBorderWidth: 1,
                        pointRadius: 4,
                        pointHoverRadius: 2,
                        pointBackgroundColor: 'rgba(75, 192, 192, 1)',
                        pointBorderColor: '#fff',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    elements: {
                        line: {
                            tension: 0.4,
                        }
                    },
                    scales: {
                        y: {
                            border: {
                                display: false
                            },
                            grid: {
                                display: true,
                                color: "#F0F0F0",
                                drawBorder: false,
                            },
                            ticks: {
                                beginAtZero: false,
                                autoSkip: true,
                                maxTicksLimit: 4,
                                color: "#6B778C",
                                font: {
                                    size: 10,
                                }
                            }
                        },
                        x: {
                            border: {
                                display: false
                            },
                            grid: {
                                display: false,
                                drawBorder: false,
                            },
                            ticks: {
                                beginAtZero: false,
                                autoSkip: true,
                                maxTicksLimit: 7,
                                color: "#6B778C",
                                font: {
                                    size: 10,
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false,
                        }
                    }
                }
            });
        }
    }

    if ($("#status-summary").length) { 
        const statusSummaryChartCanvas = document.getElementById('status-summary');
        new Chart(statusSummaryChartCanvas, {
          type: 'line',
          data: {
            labels: ["SUN", "MON", "TUE", "WED", "THU", "FRI"],
            datasets: [{
                label: '# of Votes',
                data: [50, 68, 70, 10, 12, 80],
                backgroundColor: "#ffcc00",
                borderColor: [
                    '#01B6A0',
                ],
                borderWidth: 2,
                fill: false, // 3: no fill
                pointBorderWidth: 0,
                pointRadius: [0, 0, 0, 0, 0, 0],
                pointHoverRadius: [0, 0, 0, 0, 0, 0],
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            elements: {
              line: {
                  tension: 0.4,
              }
          },
            scales: {
              y: {
                border: {
                  display: false
                },
                display: false,
                grid: {
                  display: false,
                },
              },
              x: {
                border: {
                  display: false
                },
                display: false,
                grid: {
                  display: false,
                }
              }
            },
            plugins: {
              legend: {
                  display: false,
              }
            }
          }
        });
      }
  
      if ($("#marketingOverview").length) { 
        const marketingOverviewCanvas = document.getElementById('marketingOverview');
        new Chart(marketingOverviewCanvas, {
          type: 'bar',
          data: {
            labels: ["JAN","FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"],
            datasets: [{
              label: 'Last week',
              data: [110, 220, 200, 190, 220, 110, 210, 110, 205, 202, 201, 150],
              backgroundColor: "#52CDFF",
              borderColor: [
                  '#52CDFF',
              ],
                borderWidth: 0,
                barPercentage: 0.35,
                fill: true, // 3: no fill
                
            },{
              label: 'This week',
              data: [215, 290, 210, 250, 290, 230, 290, 210, 280, 220, 190, 300],
              backgroundColor: "#1F3BB3",
              borderColor: [
                  '#1F3BB3',
              ],
              borderWidth: 0,
                barPercentage: 0.35,
                fill: true, // 3: no fill
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            elements: {
              line: {
                  tension: 0.4,
              }
          },
          
            scales: {
              y: {
                border: {
                  display: false
                },
                grid: {
                  display: true,
                  drawTicks: false,
                  color:"#F0F0F0",
                  zeroLineColor: '#F0F0F0',
                },
                ticks: {
                  beginAtZero: false,
                  autoSkip: true,
                  maxTicksLimit: 4,
                  color:"#6B778C",
                  font: {
                    size: 10,
                  }
                }
              },
              x: {
                border: {
                  display: false
                },
                stacked: true,
                grid: {
                  display: false,
                  drawTicks: false,
                },
                ticks: {
                  beginAtZero: false,
                  autoSkip: true,
                  maxTicksLimit: 7,
                  color:"#6B778C",
                  font: {
                    size: 10,
                  }
                }
              }
            },
            plugins: {
              legend: {
                  display: false,
              }
            }
          },
          plugins: [{
            afterDatasetUpdate: function (chart, args, options) {
                const chartId = chart.canvas.id;
                var i;
                const legendId = `${chartId}-legend`;
                const ul = document.createElement('ul');
                for(i=0;i<chart.data.datasets.length; i++) {
                    ul.innerHTML += `
                    <li>
                      <span style="background-color: ${chart.data.datasets[i].borderColor}"></span>
                      ${chart.data.datasets[i].label}
                    </li>
                  `;
                }
                return document.getElementById(legendId).appendChild(ul);
              }
          }]
        });
      }
  
      if ($('#totalVisitors').length) {
        var bar = new ProgressBar.Circle(totalVisitors, {
          color: '#fff',
          // This has to be the same size as the maximum width to
          // prevent clipping
          strokeWidth: 15,
          trailWidth: 15, 
          easing: 'easeInOut',
          duration: 1400,
          text: {
            autoStyleContainer: false
          },
          from: {
            color: '#52CDFF',
            width: 15
          },
          to: {
            color: '#677ae4',
            width: 15
          },
          // Set default step function for all animate calls
          step: function(state, circle) {
            circle.path.setAttribute('stroke', state.color);
            circle.path.setAttribute('stroke-width', state.width);
    
            var value = Math.round(circle.value() * 100);
            if (value === 0) {
              circle.setText('');
            } else {
              circle.setText(value);
            }
    
          }
        });
    
        bar.text.style.fontSize = '0rem';
        bar.animate(.64); // Number from 0.0 to 1.0
      }
  
      if ($('#visitperday').length) {
        var bar = new ProgressBar.Circle(visitperday, {
          color: '#fff',
          // This has to be the same size as the maximum width to
          // prevent clipping
          strokeWidth: 15,
          trailWidth: 15,
          easing: 'easeInOut',
          duration: 1400,
          text: {
            autoStyleContainer: false
          },
          from: {
            color: '#34B1AA',
            width: 15
          },
          to: {
            color: '#677ae4',
            width: 15
          },
          // Set default step function for all animate calls
          step: function(state, circle) {
            circle.path.setAttribute('stroke', state.color);
            circle.path.setAttribute('stroke-width', state.width);
    
            var value = Math.round(circle.value() * 100);
            if (value === 0) {
              circle.setText('');
            } else {
              circle.setText(value);
            }
    
          }
        });
    
        bar.text.style.fontSize = '0rem';
        bar.animate(.34); // Number from 0.0 to 1.0
      }
  
      $.ajax({
        url: 'src/pages/admin/controller/data-kategori.php', // URL ke file PHP
        type: 'GET',
        success: function(data) {
            try {
                var parsedData = JSON.parse(data);
                renderDataKategori(parsedData);
            } catch (error) {
                console.error('Error parsing JSON:', error);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX error:', status, error);
        }
    });

    function renderDataKategori(data) {
        if ($("#dataKategori").length) {
            const labels = data.map(row => row.nama_kategori);
            const dataset = data.map(row => row.total_penjualan);

            const dataKategoriCanvas = document.getElementById('dataKategori');
            const chart = new Chart(dataKategoriCanvas, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: dataset,
                        backgroundColor: [
                            "#1F3BB3",
                            "#FDD0C7",
                            "#52CDFF",
                            "#81DADA",
                            "#FF6384",
                            "#36A2EB",
                            "#FFCE56"
                        ],
                        borderColor: [
                            "#1F3BB3",
                            "#FDD0C7",
                            "#52CDFF",
                            "#81DADA",
                            "#FF6384",
                            "#36A2EB",
                            "#FFCE56"
                        ],
                    }]
                },
                options: {
                  cutout: 30, // Atur nilai cutout sesuai kebutuhan
                  animation: {
                      animateRotate: true,
                      animateScale: true
                  },
                  responsive: true,
                  maintainAspectRatio: false,
                  plugins: {
                      legend: {
                          display: false,
                      }
                  }
              }
              
            });

            createCustomLegend(chart, 'dataKategori-legend');
        }
    }

    function createCustomLegend(chart, legendId) {
        const legendElement = document.getElementById(legendId);
        if (legendElement) {
            legendElement.innerHTML = ''; // Clear previous content
            const ul = document.createElement('ul');
            ul.style.listStyleType = 'none';
            ul.style.padding = 0;
            chart.data.labels.forEach((label, i) => {
                const li = document.createElement('li');
                li.style.display = 'flex';
                li.style.alignItems = 'center';
                li.style.marginBottom = '4px';

                const box = document.createElement('span');
                box.style.display = 'inline-block';
                box.style.width = '12px';
                box.style.height = '12px';
                box.style.backgroundColor = chart.data.datasets[0].backgroundColor[i];
                box.style.marginRight = '8px';

                const text = document.createTextNode(label);

                li.appendChild(box);
                li.appendChild(text);
                ul.appendChild(li);
            });
            legendElement.appendChild(ul);
        }
    }
  
      if ($("#leaveReport").length) { 
        const leaveReportCanvas = document.getElementById('leaveReport');
        new Chart(leaveReportCanvas, {
          type: 'bar',
          data: {
            labels: ["Jan","Feb", "Mar", "Apr", "May"],
            datasets: [{
                label: 'Last week',
                data: [18, 25, 39, 11, 24],
                backgroundColor: "#52CDFF",
                borderColor: [
                    '#52CDFF',
                ],
                borderWidth: 0,
                fill: true, // 3: no fill
                barPercentage: 0.5,
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            elements: {
              line: {
                  tension: 0.4,
              }
          },
            scales: {
              y: {
                border: {
                  display: false
                },
                display: true,
                grid: {
                  display: false,
                  drawBorder: false,
                  color:"rgba(255,255,255,.05)",
                  zeroLineColor: "rgba(255,255,255,.05)",
                },
                ticks: {
                  beginAtZero: true,
                  autoSkip: true,
                  maxTicksLimit: 5,
                  fontSize: 10,
                  color:"#6B778C",
                  font: {
                    size: 10,
                  }
                }
              },
              x: {
                border: {
                  display: false
                },
                display: true,
                grid: {
                  display: false,
                },
                ticks: {
                  beginAtZero: false,
                  autoSkip: true,
                  maxTicksLimit: 7,
                  fontSize: 10,
                  color:"#6B778C",
                  font: {
                    size: 10,
                  }
                }
              }
            },
            plugins: {
              legend: {
                  display: false,
              }
            }
          }
        });
      }
  
  
      if ($.cookie('staradmin2-pro-banner')!="true") {
        document.querySelector('#proBanner').classList.add('d-flex');
        document.querySelector('.navbar').classList.remove('fixed-top');
      }
      else {
        document.querySelector('#proBanner').classList.add('d-none');
        document.querySelector('.navbar').classList.add('fixed-top');
      }
      
      if ($( ".navbar" ).hasClass( "fixed-top" )) {
        document.querySelector('.page-body-wrapper').classList.remove('pt-0');
        document.querySelector('.navbar').classList.remove('pt-5');
      }
      else {
        document.querySelector('.page-body-wrapper').classList.add('pt-0');
        document.querySelector('.navbar').classList.add('pt-5');
        document.querySelector('.navbar').classList.add('mt-3');
        
      }
      document.querySelector('#bannerClose').addEventListener('click',function() {
        document.querySelector('#proBanner').classList.add('d-none');
        document.querySelector('#proBanner').classList.remove('d-flex');
        document.querySelector('.navbar').classList.remove('pt-5');
        document.querySelector('.navbar').classList.add('fixed-top');
        document.querySelector('.page-body-wrapper').classList.add('proBanner-padding-top');
        document.querySelector('.navbar').classList.remove('mt-3');
        var date = new Date();
        date.setTime(date.getTime() + 24 * 60 * 60 * 1000); 
        $.cookie('staradmin2-pro-banner', "true", { expires: date });
      });
      
    });
    iconify.load('icons.svg').then(function() {
      iconify(document.querySelector('.my-cool.icon'));
    
});





