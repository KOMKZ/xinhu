<?php
/**
*	模块：wordxie.文档协作，
*	说明：自定义区域内可写您想要的代码，模块列表页面，生成分为2块
*	来源：流程模块→表单元素管理→[模块.文档协作]→生成列表页
*/
defined('HOST') or die ('not access');
?>
<script>
$(document).ready(function(){
	{params}
	var modenum = 'wordxie',modename='文档协作',isflow=0,modeid='86',atype = params.atype,pnum=params.pnum,modenames='';
	if(!atype)atype='';if(!pnum)pnum='';
	var fieldsarr = [{"name":"\u7533\u8bf7\u4eba","fields":"base_name"},{"name":"\u7533\u8bf7\u4eba\u90e8\u95e8","fields":"base_deptname"},{"name":"\u5355\u53f7","fields":"sericnum"},{"fields":"wtype","name":"\u7c7b\u578b","fieldstype":"select","ispx":"1","isalign":"0","islb":"1"},{"fields":"name","name":"\u6587\u6863\u540d\u79f0","fieldstype":"text","ispx":"0","isalign":"1","islb":"1"},{"fields":"fenlei","name":"\u5206\u7c7b","fieldstype":"text","ispx":"1","isalign":"0","islb":"1"},{"fields":"xiename","name":"\u534f\u4f5c\u4eba","fieldstype":"changedeptusercheck","ispx":"0","isalign":"0","islb":"1"},{"fields":"recename","name":"\u53ef\u67e5\u770b\u4eba","fieldstype":"changedeptusercheck","ispx":"0","isalign":"0","islb":"1"},{"fields":"optname","name":"\u521b\u5efa\u4eba","fieldstype":"text","ispx":"1","isalign":"0","islb":"1"},{"fields":"optdt","name":"\u64cd\u4f5c\u65f6\u95f4","fieldstype":"datetime","ispx":"1","isalign":"0","islb":"1"},{"fields":"explian","name":"\u8bf4\u660e","fieldstype":"textarea","ispx":"0","isalign":"0","islb":"1"},{"fields":"temp_opt","name":"\u64cd\u4f5c","fieldstype":"text","ispx":"0","isalign":"0","islb":"1"}],fieldsselarr= [];
	
	var c = {
		reload:function(){
			a.reload();
		},
		clickwin:function(o1,lx){
			var id=0;
			if(lx==1)id=a.changeid;
			openinput(modename,modenum,id,'opegs{rand}');
		},
		view:function(){
			var d=a.changedata;
			openxiangs(modename,modenum,d.id,'opegs{rand}');
		},
		searchbtn:function(){
			this.search({});
		},
		search:function(cans){
			var s=get('key_{rand}').value,zt='';
			if(get('selstatus_{rand}'))zt=get('selstatus_{rand}').value;
			var canss = js.apply({key:s,keystatus:zt,search_value:''}, cans);
			a.setparams(canss,true);
		},
		//高级搜索
		searchhigh:function(){
			new highsearchclass({
				modenum:modenum,
				oncallback:function(d){
					c.searchhighb(d);
				}
			});
		},
		searchhighb:function(d){
			d.key='';
			d.search_value='';
			get('key_{rand}').value='';
			a.setparams(d,true);
		},
		searchuname:function(d){
			js.getuser({
				type:'deptusercheck',
				title:'搜索'+d.name,
				changevalue:this.search_value,
				callback:function(sna,sid){
					c.searchunames(d,sna,sid);
				}
			});
		},
		search_value:'',
		searchunames:function(d,sna,sid){
			get('key_{rand}').value=sna;
			this.search_value = sid;
			var cs = {key:'','search_fields':d.fields,'search_value':sid};
			a.setparams(cs,true);
		},
		daochu:function(o1,lx,lx1,e){
			publicdaochuobj({
				'objtable':a,
				'modename':modename,
				'fieldsarr':fieldsarr,
				'modenum':modenum,
				'modenames':modenames,
				'isflow':isflow,
				'btnobj':o1
			});
		},
		getacturl:function(act){
			return js.getajaxurl(act,'mode_wordxie|input','flow',{'modeid':modeid});
		},
		changatype:function(o1,lx){
			$("button[id^='changatype{rand}']").removeClass('active');
			$('#changatype{rand}_'+lx+'').addClass('active');
			a.setparams({atype:lx},true);
			nowtabssettext($(o1).html());
		},
		init:function(){
			$('#key_{rand}').keyup(function(e){
				if(e.keyCode==13)c.searchbtn();
			});
			this.initpage();
		},
		initpage:function(){
			
		},
		loaddata:function(d){
			this.setdownsodata(d.souarr);
			if(!d.atypearr)return;
			get('addbtn_{rand}').disabled=(d.isadd!=true);
			get('daobtn_{rand}').disabled=(d.isdaochu!=true);
			if(d.isdaochu)$('#daobtn_{rand}').show();
			if(d.isdaoru)$('#daoruspan_{rand}').show();
			var d1 = d.atypearr,len=d1.length,i,str='';
			for(i=0;i<len;i++){
				str+='<button class="btn btn-default" click="changatype,'+d1[i].num+'" id="changatype{rand}_'+d1[i].num+'" type="button">'+d1[i].name+'</button>';
			}
			$('#changatype{rand}').html(str);
			$('#changatype{rand}_'+atype+'').addClass('active');
			js.initbtn(c);
		},
		setdownsodata:function(darr){
			var ddata = [{name:'高级搜索',lx:0}],dsd,i;
			if(darr)for(i=0;i<darr.length;i++){
				dsd = darr[i];
				dsd.lx=3;
				ddata.push(dsd);
			}
			if(admintype==1)ddata.push({name:'自定义列显示',lx:2});
			ddata.push({name:'打印',lx:1});
			this.soudownobj.setData(ddata);
		},
		setcolumns:function(fid, cnas){
			var d = false,i,ad=bootparams.columns,len=ad.length,oi=-1;
			for(i=0;i<len;i++){
				if(ad[i].dataIndex==fid){
					d = ad[i];
					oi= i;
					break;
				}
			}
			if(d){
				d = js.apply(d, cnas);
				bootparams.columns[oi]=d;
			}
		},
		daoru:function(){
			window.managelistwordxie = a;
			addtabs({num:'daoruwordxie',url:'flow,input,daoru,modenum=wordxie',icons:'plus',name:'导入文档协作'});
		},
		initcolumns:function(bots){
			var num = 'columns_'+modenum+'_'+pnum+'',d=[],d1,d2={},i,len=fieldsarr.length,bok;
			var nstr= fieldsselarr[num];if(!nstr)nstr='';
			if(nstr)nstr=','+nstr+',';
			if(nstr=='' && isflow>0){
				d.push({text:'申请人',dataIndex:'base_name',sortable:true});
				d.push({text:'申请人部门',dataIndex:'base_deptname',sortable:true});
			}
			for(i=0;i<len;i++){
				d1 = fieldsarr[i];
				bok= false;
				if(nstr==''){
					if(d1['islb']=='1')bok=true;
				}else{
					if(nstr.indexOf(','+d1.fields+',')>=0)bok=true;
				}
				if(bok){
					d2={text:d1.name,dataIndex:d1.fields};
					if(d1.ispx=='1')d2.sortable=true;
					if(d1.isalign=='1')d2.align='left';
					if(d1.isalign=='2')d2.align='right';
					d.push(d2);
				}
			}
			if(isflow>0)d.push({text:'状态',dataIndex:'statustext'});
			if(nstr=='' || nstr.indexOf(',caozuo,')>=0)d.push({text:'',dataIndex:'caozuo',callback:'opegs{rand}'});
			if(!bots){
				bootparams.columns=d;
			}else{
				a.setColumns(d);
			}
		},
		setparams:function(cs){
			var ds = js.apply({},cs);
			a.setparams(ds);
		},
		storeurl:function(){
			var url = this.getacturl('publicstore')+'&pnum='+pnum+'';
			return url;
		},
		printlist:function(){
			js.msg('success','可使用导出，然后打开在打印');
		},
		getbtnstr:function(txt, click, ys, ots){
			if(!ys)ys='default';
			if(!ots)ots='';
			return '<button class="btn btn-'+ys+'" id="btn'+click+'_{rand}" click="'+click+'" '+ots+' type="button">'+txt+'</button>';
		},
		setfieldslist:function(){
			new highsearchclass({
				modenum:modenum,
				modeid:modeid,
				type:1,
				isflow:isflow,
				pnum:pnum,atype:atype,
				fieldsarr:fieldsarr,
				fieldsselarr:fieldsselarr,
				oncallback:function(str){
					fieldsselarr[this.columnsnum]=str;
					c.initcolumns(true);
					c.reload();
				}
			});
		}
	};	
	
	//表格参数设定
	var bootparams = {
		fanye:true,modenum:modenum,modename:modename,statuschange:false,tablename:jm.base64decode('d29yZHhpZQ::'),
		url:c.storeurl(),storeafteraction:'storeaftershow',storebeforeaction:'storebeforeshow',
		params:{atype:atype},
		columns:[{text:"类型",dataIndex:"wtype",sortable:true},{text:"文档名称",dataIndex:"name",align:"left"},{text:"分类",dataIndex:"fenlei",sortable:true},{text:"协作人",dataIndex:"xiename"},{text:"可查看人",dataIndex:"recename"},{text:"创建人",dataIndex:"optname",sortable:true},{text:"操作时间",dataIndex:"optdt",sortable:true},{text:"说明",dataIndex:"explian"},{text:"操作",dataIndex:"temp_opt"},{
			text:'',dataIndex:'caozuo',callback:'opegs{rand}'
		}],
		itemdblclick:function(){
			c.view();
		},
		load:function(d){
			c.loaddata(d);
		}
	};
	c.initcolumns(false);
	opegs{rand}=function(){
		c.reload();
	}
	
//[自定义区域start]

c.setcolumns('wtype', {
	renderer:function(v,d){
		return '<img src="web/images/fileicons/'+v+'.gif" height="20">';
	}
});
c.setcolumns('name', {
	renderer:function(v,d){
		var ss=' <span class="label label-success label-sm">协作</span>';
		if(!d.xiebool)ss=' <span class="label label-default">只读</span>';
		return ''+v+'.'+d.wtype+''+ss+'';
	}
});
c.setcolumns('temp_opt', {
	renderer:function(v,d,oi){
		var lxs = ',doc,docx,xls,xlsx,ppt,pptx,';
	
		var str = (lxs.indexOf(','+d.wtype+',')>-1 && d.xiebool) ? '&nbsp;<a href="javascript:;" onclick="showvies{rand}('+oi+',3)">编辑</a>&nbsp;<a href="javascript:;" onclick="showvies{rand}('+oi+',1)"><i class="icon-arrow-down"></i></a>' : '';
		return '<a href="javascript:;" onclick="showvies{rand}('+oi+',0)">预览</a>'+str+'';
	},
	text:'&nbsp;'
});
showvies{rand}=function(oi,lx){
	var d=a.getData(oi);
	if(lx==3){
		js.sendeditoffice(d.fileid);
		return;
	}
	if(lx==1){
		js.downshow(d.fileid)
	}else{
		js.yulanfile(d.fileid,d.wtype,d.filepath,d.name);
	}
}
$('#viewwordxie_{rand}').after('<div class="tishi">如没有在线编辑插件，可用下载下来编辑写好了在上传，上传的文档名称需一致。</div>');
$('#tdright_{rand}').prepend(c.getbtnstr('上传写好文件','upxieok')+'&nbsp;');
var btnupobj = get('btnupxieok_{rand}');
btnupobj.disabled=true;
bootparams.itemclick=function(d){
	btnupobj.disabled = (!d.xiebool);	
}
bootparams.load=function(d){
	c.loaddata(d);
	btnupobj.disabled=true;
}
c.upxieok=function(){
	var d = a.changedata;
	js.upload('upfilexiezuo{rand}|upchagneback{rand}',{maxup:'1','title':d.name+'.'+d.wtype,uptype:d.wtype});
}
upchagneback{rand}=function(f){
	var d = a.changedata;
	if(f.name.indexOf(d.name)!=0)return '选择的文件名不一致，必须选['+d.name+'.'+d.wtype+']';
}
upfilexiezuo{rand}=function(d){
	js.ajax(c.getacturl('savefile'),{'id':a.changedata.id,'upfileid':d[0].id},function(s){
		a.reload();
	},'get',false, '保存中...,保存成功');
}

//[自定义区域end]

	js.initbtn(c);
	var a = $('#viewwordxie_{rand}').bootstable(bootparams);
	c.init();
	c.soudownobj = $('#downbtn_{rand}').rockmenu({
		width:120,top:35,donghua:false,
		data:[{name:'高级搜索',lx:0}],
		itemsclick:function(d, i){
			if(d.lx==0)c.searchhigh();
			if(d.lx==1)c.printlist();
			if(d.lx==2)c.setfieldslist();
			if(d.lx==3)c.searchuname(d);
		}
	});
	
	
});
</script>
<!--SCRIPTend-->
<!--HTMLstart-->
<div>
	<table width="100%">
	<tr>
		<td style="padding-right:10px;" id="tdleft_{rand}" nowrap><button id="addbtn_{rand}" class="btn btn-primary" click="clickwin,0" disabled type="button"><i class="icon-plus"></i> 新增</button></td>
		<td>
			<input class="form-control" style="width:160px" id="key_{rand}" placeholder="关键字">
		</td>
		
		<td style="padding-left:10px">
			<div style="white-space:nowrap">
			<button style="border-right:0;border-top-right-radius:0;border-bottom-right-radius:0" class="btn btn-default" click="searchbtn" type="button">搜索</button><button class="btn btn-default" id="downbtn_{rand}" type="button" style="padding-left:8px;padding-right:8px;border-top-left-radius:0;border-bottom-left-radius:0"><i class="icon-angle-down"></i></button> 
			</div>
		</td>
		<td  width="90%" style="padding-left:10px"><div id="changatype{rand}" class="btn-group"></div></td>
	
		<td align="right" id="tdright_{rand}" nowrap>
			<button class="btn btn-default" style="display:none" id="daobtn_{rand}" disabled click="daochu" type="button">导出 <i class="icon-angle-down"></i></button> 
		</td>
	</tr>
	</table>
</div>
<div class="blank10"></div>
<div id="viewwordxie_{rand}"></div>
<!--HTMLend-->