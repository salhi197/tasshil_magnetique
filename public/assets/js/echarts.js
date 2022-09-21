$(function(e) {
	'use strict'
	/*-----echart2-----*/
	var les_semaines = $("#echart2").attr('semaines');

	les_semaines = (JSON.parse(les_semaines));
	
	var montants = $("#echart2").attr('montants');
	
	montants = (JSON.parse(montants));
	
	var chartdata2 = [{
		name: 'Recette',
		type: 'line',
		smooth: true,
		data: montants,
		color: ['#11F966']
	}];
	var chart2 = document.getElementById('echart2');
	var barChart2 = echarts.init(chart2);
	var option2 = {
		grid: {
			top: '6',
			right: '0',
			bottom: '17',
			left: '25',
		},

		tooltip: {
			show: true,
			showContent: true,
			alwaysShowContent: true,
			triggerOn: 'mousemove',
			trigger: 'axis',
			axisPointer: {
				label: {
					show: false,
				}
			}
		},

		xAxis: {
			data: les_semaines,
			axisLine: {
				lineStyle: {
					color: 'rgb(227, 226, 236,0.4)'
				}
			},
			axisLabel: {
				fontSize: 10,
				color: '#9493a9'
			}
		},
		yAxis: {
			splitLine: {
				lineStyle: {
					color: 'rgb(227, 226, 236,0.4)'
				}
			},
			axisLine: {
				lineStyle: {
					color: 'rgb(227, 226, 236,0.4)'
				}
			},
			axisLabel: {
				fontSize: 7,
				color: '#9493a9'
			}
		},
		series: chartdata2
	};
	barChart2.setOption(option2);



	/**/
});