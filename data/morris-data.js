$(function() {

    Morris.Bar({
        element: 'morris-area-chart',
        data: [{
            period: 'ENERO',
            NUEVAS: 2000,
            PROGRAMADAS: 2666,
            RESUELTOS: 200,
            PENDIENTES: 2647
        }, {
            period: 'FEBRERO',
            NUEVAS: 2000,
            PROGRAMADAS: 2778,
            RESUELTOS: 2294,
            PENDIENTES: 2441
        }, {
            period: 'MARZO',
            NUEVAS: 2000,
            PROGRAMADAS: 4912,
            RESUELTOS: 1969,
            PENDIENTES: 2501
        }, {
            period: 'ABRIL',
            NUEVAS: 2000,
            PROGRAMADAS: 3767,
            RESUELTOS: 3597,
            PENDIENTES: 5689
        }, {
            period: 'MAYO',
            NUEVAS: 2000,
            PROGRAMADAS: 6810,
            RESUELTOS: 1914,
            PENDIENTES: 2293
        }, {
            period: 'MAYO',
            NUEVAS: 2000,
            PROGRAMADAS: 5670,
            RESUELTOS: 4293,
            PENDIENTES: 1881
        }, {
            period: 'JUNIO',
            NUEVAS: 2000,
            PROGRAMADAS: 4820,
            RESUELTOS: 3795,
            PENDIENTES: 1588
        }, {
            period: 'JULIO',
            NUEVAS: 2000,
            PROGRAMADAS: 15073,
            RESUELTOS: 5967,
            PENDIENTES: 5175
        }, {
            period: 'AGOSTO',
            NUEVAS: 2000,
            PROGRAMADAS: 10687,
            RESUELTOS: 4460,
            PENDIENTES: 2028
        }, {
            period: 'SEPTIEMBRE',
            NUEVAS: 2000,
            PROGRAMADAS: 8432,
            RESUELTOS: 5713,
            PENDIENTES: 1791
        }],
        xkey: 'period',
        ykeys: ['NUEVAS', 'PROGRAMADAS', 'RESUELTOS', 'PENDIENTES'],
        labels: ['NUEVAS', 'PROGRAMADAS', 'RESUELTOS', 'PENDIENTES'],
        pointSize: 2,
        hideHover: 'auto',
        resize: true
    });

    Morris.Bar({
        element: 'morris-bar-chart',
        data: [{
            y: '2006',
            a: 100,
            b: 90
        }, {
            y: '2007',
            a: 75,
            b: 65
        }, {
            y: '2008',
            a: 50,
            b: 40
        }, {
            y: '2009',
            a: 75,
            b: 65
        }, {
            y: '2010',
            a: 50,
            b: 40
        }, {
            y: '2011',
            a: 75,
            b: 65
        }, {
            y: '2012',
            a: 100,
            b: 90
        }],
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Series A', 'Series B'],
        hideHover: 'auto',
        resize: true
    });
    
});
