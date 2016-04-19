// 纯JS省市区三级联动
// 2011-11-30 by http://www.cnblogs.com/zjfree
var addressInit = function(_cmbProvince, _cmbCity, defaultProvince, defaultCity)
{
	var cmbProvince = document.getElementById(_cmbProvince);
	var cmbCity = document.getElementById(_cmbCity);
	
	function cmbSelect(cmb, str)
	{
		for(var i=0; i<cmb.options.length; i++)
		{
			if(cmb.options[i].value == str)
			{
				cmb.selectedIndex = i;
				return;
			}
		}
	}
	function cmbAddOption(cmb, str, obj)
	{
		var option = document.createElement("OPTION");
		cmb.options.add(option);
		option.innerHTML = str;
		option.value = str;
		option.obj = obj;
	}
	
	function changeProvince()
	{
		cmbCity.options.length = 0;
		cmbCity.onchange = null;
		if(cmbProvince.selectedIndex == -1)return;
		var item = cmbProvince.options[cmbProvince.selectedIndex].obj;
		for(var i=0; i<item.cityList.length; i++)
		{
			cmbAddOption(cmbCity, item.cityList[i].name, item.cityList[i]);
		}
		cmbSelect(cmbCity, defaultCity);
	}
	
	for(var i=0; i<provinceList.length; i++)
	{
		cmbAddOption(cmbProvince, provinceList[i].name, provinceList[i]);
	}
	cmbSelect(cmbProvince, defaultProvince);
	changeProvince();
	cmbProvince.onchange = changeProvince;
}
var provinceList = [
{name:'上海', cityList:[
{name:'全部'},
{name:'黄浦区'},
{name:'卢湾区'},
{name:'徐汇区'},
{name:'长宁区'},
{name:'静安区'},
{name:'普陀区'},
{name:'闸北区'},
{name:'虹口区'},
{name:'杨浦区'},
{name:'闵行区'},
{name:'宝山区'},
{name:'嘉定区'},
{name:'浦东新区'},
{name:'金山区'},
{name:'松江区'},
{name:'青浦区'},
{name:'南汇区'},
{name:'奉贤区'},
{name:'崇明县'},
]},
];