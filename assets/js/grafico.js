function graficoBarrasTotal(idDiv, legenda, corBarra, casaAnuncio, apAnuncio, apPlantaAnuncio, salaAnuncio, predioAnuncio, terrenoAnuncio){
    
    $(document).ready(function () {
    var myChart = echarts.init(document.getElementById(idDiv)); 
        
        var option = {
            tooltip: {
                show: true
            },
            legend: {
                data:[legenda]
            },
            
            toolbox: {
                show : true,
                feature : {
                    magicType : {show: true, type: ['line', 'bar'], title : {
                        line : 'Ver em Linhas', bar : 'Ver em Barras'
                                },
                        },
                    saveAsImage : {show: true, title :'Copiar Imagem', lang:['Copiar Imagem']}
                }
            },
            
            
            
            xAxis : [
                {
                    type : 'category',
                    data : ["Casa", "Apartamento", "Ap na Planta", "Sala", "Prédio", "Terreno"]
                }
            ],
            yAxis : [
                {
                    type : 'value'
                }
            ],
            
            series : [
                {
                    "name":legenda,
                    "type":"bar",
                     itemStyle: {normal: {color:corBarra, label:{show:true,textStyle:{color:'#27727B'}}}},
                    "data":[casaAnuncio, apAnuncio, apPlantaAnuncio, salaAnuncio, predioAnuncio, terrenoAnuncio],
                /*    markPoint : {
                    data : [
                    {value : casaAnuncio, xAxis: 0, yAxis: casaAnuncio, symbolSize:18},
                    {value : terrenoAnuncio, xAxis: 5, yAxis: terrenoAnuncio, symbolSize:18}
                            ]
                    },*/
                    
                }
            ]
        };

        // Load data into the ECharts instance 
        myChart.setOption(option); 
    })      
}
