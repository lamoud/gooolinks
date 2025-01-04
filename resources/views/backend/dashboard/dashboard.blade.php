@extends('backend/layouts/master')

@section('content')

<div class="wrapper d-flex align-items-stretch">
    @include('backend.layouts.partials.dashboard-sidebar')
    
    <div id="content" class="p-4 p-md-5 pt-5">

        <div class="container">
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="stat-card">
                        <div class="start-col">
                            <h2 class="head">{{ __('Users') }}</h2>
                            <h3>{{ $totalUsers }}</h3>
                        </div>
                        <div class="end-col">
                            <div class="dropdown">
                                <span class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    آخر شهر
                                </span>
                            </div>
                            <span class="growth">
                                {{ $userGrowthRate }}%
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trending-up"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 17l6 -6l4 4l8 -8" /><path d="M14 7l7 0l0 7" /></svg>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="stat-card">
                        <div class="start-col">
                            <h2 class="head">الإشتراكات</h2>
                            <h3>{{ $totalSubscriptions }}</h3>
                        </div>
                        <div class="end-col">
                            <div class="dropdown">
                                <span class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    آخر شهر
                                </span>
                            </div>
                            <span class="growth">
                                {{ $subscriptionGrowthRate }}%
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trending-up"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 17l6 -6l4 4l8 -8" /><path d="M14 7l7 0l0 7" /></svg>
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="stat-card">
                        <div class="start-col">
                            <h2 class="head">المدفوعات</h2>
                            <h3>{{ $totalPayments }}$</h3>
                        </div>
                        <div class="end-col">
                            <div class="dropdown">
                                <span class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    آخر شهر
                                </span>
                            </div>
                            <span class="growth">
                                {{ $paymentGrowthRate }}%
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trending-up"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 17l6 -6l4 4l8 -8" /><path d="M14 7l7 0l0 7" /></svg>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="stat-card">
                        <div class="start-col">
                            <h2 class="head">زيارات جديدة</h2>
                            <h3>{{ $totalVisits }}</h3>
                        </div>
                        <div class="end-col">
                            <div class="dropdown">
                                <span class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    آخر شهر
                                </span>
                            </div>
                            <span class="growth">
                                {{ $visitGrowthRate }}%
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trending-up"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 17l6 -6l4 4l8 -8" /><path d="M14 7l7 0l0 7" /></svg>
                            </span>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row mb-4">
                <div class="col-md-4">
                    <h2 class="h4">المشتركين والزوار</h2>
                    <div class="card border-0 shadow-sm rounded h-100">
                        <div class="card-body py-4">
                            <canvas id="doughnutChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <h2 class="h4">النشاط الاسبوعي</h2>
                    <div class="card border-0 shadow-sm rounded h-100">
                        <div class="card-body py-4">
                            <canvas id="barChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js"></script>
<script>
    // جلب البيانات الديناميكية من PHP إلى JavaScript
    var subscriptionsData = @json($weeklySubscriptions);
    var usersData = @json($weeklyNewUsers);

    var barCtx = document.getElementById('barChart').getContext('2d');
    var barChart = new Chart(barCtx, {
      type: 'bar',
      data: {
        labels: ['سبت', 'أحد', 'إثنين', 'ثلاثاء', 'أربعاء', 'خميس', 'جمعة'],
        datasets: [
          {
            label: 'إشتراكات',
            backgroundColor: '#16DBCC',
            borderColor: '#16DBCC',
            borderWidth: 1,
            borderRadius: 20,
            barThickness: 20,
            data: subscriptionsData // بيانات الاشتراكات الأسبوعية
          },
          {
            label: 'حسابات جديدة',
            backgroundColor: '#FF82AC',
            borderColor: '#FF82AC',
            borderWidth: 1,
            borderRadius: 20,
            barThickness: 20,
            data: usersData // بيانات الحسابات الجديدة الأسبوعية
          }
        ]
      },
      options: {
        responsive: true,
        scales: {
          x: {
            grid: {
              display: false
            },
            ticks: {
              color: '#444',
            }
          },
          y: {
            beginAtZero: true,
            grid: {
              borderDash: [5, 5],
              color: '#ddd'
            },
            ticks: {
              color: '#444',
              stepSize: 1
            }
          }
        },
        plugins: {
          legend: {
            position: 'top',
            align: 'end',
            labels: {
              usePointStyle: true,
              pointStyle: 'circle',
              color: '#444'
            }
          }
        }
      }
    });


  var doughnutCtx = document.getElementById('doughnutChart').getContext('2d');
  var doughnutChart = new Chart(doughnutCtx, {
    type: 'doughnut',
    data: {
      labels: ['الباقة المجانية', 'الباقة الأساسية', 'الباقة الأفضل', 'زوار جدد'],
      datasets: [{
        backgroundColor: ['#FF82AC', '#ffcd56', '#16DBCC', '#36a2eb'],
        data: [12247, 3280, 4253, 3280]
      }]
    },
    options: {
      responsive: true,
      cutout: '50%',
      
      plugins: {
        legend: {
          position: 'bottom',
          align: 'start',
          labels: {
            usePointStyle: true,
            pointStyle: 'circle',
            color: '#444'
          }
        }
      }
    }
  });
</script>
@endsection