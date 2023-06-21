/* globals Chart:false, feather:false */



(function () {

  'use strict'



  $('select[multiple]').select2({

    placeholder: 'Select items'

  });



  $('[name="tags"]').tagify();



  feather.replace();



  if($('.nav-link').length>0){

    $('.nav-link').removeClass('active');
    $('.nav-link').each(function(){

      if($(this).data('route')==CURRENT_ROUTE_NAME){
        $(this).addClass('active');
      }
    });

  }



  if($('#myChart').length>0){

    // Graphs

    var ctx = document.getElementById('myChart')

    // eslint-disable-next-line no-unused-vars

    var myChart = new Chart(ctx, {

      type: 'line',

      data: {

        labels: [

          'Sunday',

          'Monday',

          'Tuesday',

          'Wednesday',

          'Thursday',

          'Friday',

          'Saturday'

        ],

        datasets: [{

          data: [

            15339,

            21345,

            18483,

            24003,

            23489,

            24092,

            12034

          ],

          lineTension: 0,

          backgroundColor: 'transparent',

          borderColor: '#007bff',

          borderWidth: 4,

          pointBackgroundColor: '#007bff'

        }]

      },

      options: {

        scales: {

          yAxes: [{

            ticks: {

              beginAtZero: false

            }

          }]

        },

        legend: {

          display: false

        }

      }

    });

  }



})()

