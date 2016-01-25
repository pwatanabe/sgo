<?php
//CLASS: RendDoubleSelect
//Author: Rafael Rend - rafaelrend@gmail.com  -> Creation Date-> 2012-11-10  Year: 2012, Month: 11, Day: 10
//Site: http://www.rendti.com.br,  http://rafaelrend.wordpress.com/ 

//Description: RendDoubleSelect, show 2 select tags. Enabling selection of multiple values. 
//Descrição: RendDoubleSelect, mostra dos selects na página, permitindo que você selecione vários valores.
include_once("class_epi_bd.php");

class RendDoubleSelect{

  
  
  //Load a dropdownlist from an array ($key=>value) of results.
  //Carrega um dropdownlist, a partir de um array (tipo $key=>value) de resultados
  public static function loadDropDownArray(&$ar, $Campo1, $Campo2,  $sel, $select = false)
{
		if ($select)
			RendDoubleSelect::populateCombo(""," -- SELECIONE -- ", "");
	
		for ( $i =0 ; $i < count( $ar )  ; $i++)
		{
			$arr = $ar[$i];
			
			RendDoubleSelect::populateCombo($arr[$Campo1], $arr[$Campo2], $sel);
		}
}
	 
	 
  //Load a dropdownlist from an array of results with option to group these results.
  //Carrega um dropdownlist, a partir de um array (tipo $key=>value) de resultados, com a opção para agroupar estes resultados por um dos campos.
public static function  loadDropDownOptGroup(&$RCset, $Campo1, $Campo2, $campoGroup, $comp)
{
  $temp = ""; $group=""; $cont= "";
  $group = "";
  $cont = 0;
	if ( isset($RCset))
	{
	// Método alterado para poder receber mais de um campo no valor texto
	//(separado por |)
			$arrayTexto = explode("|",$Campo2);
			
			
	 for ( $i = 0 ; $i < count($RCset); $i++)
	 {
			$ar = $RCset[$i];
			
			if ( $group != "" && $ar[$campoGroup] != $group)
			{
			   echo "\n"."</optgroup> \n";
			   $cont = 0;	
			}
			
			$group =  $ar[$campoGroup];
			
			if ($cont== 0)
			{
			    echo "\n ". "<optgroup label='". str_replace("'","\'", $group) . "'>";
			} 
			  $cont++;
			          if ( $ar[$Campo1] == $comp)
			          {
					     $temp = "  selected";
					  } 	 
							  echo '<option  value="'. $ar[$Campo1].'" '. $temp . ">\n";  
				             for ( $z=0 ; $z < count($arrayTexto); $z++)
							  {
								if ( count($arrayTexto) > 1)
								{
									if ($arrayTexto[$z] != "") {
										echo str_replace("'","\'", $ar[$Campo2]) . " - ";
									}
								}else {
									echo str_replace("'","\'", $ar[$Campo2]);
								} 
					          }
							  echo  "</option>";
					 $temp = ""	;	  
	} 
			
			if ($cont > 0 ) {
			   echo "\n</optgroup>";
			} 
			
    }
  
}

	 
	 

       ///Write < option HTML TAG
	   //escreve a tag "option" do select
       public static function populateCombo($value, $texto, $sel=""){
	   
	      $selec = $value == $sel  ?" selected " : "";
	   	  $epi = new Epi();
	   	  //verifica a quantidade no estoque
	   	  if($epi->getQuantidade($value) <= 10 )
           		echo "<option style='background-color:#f33;'  $selec value=\"$value\">" . $texto . "</option>";
          else
          		echo "<option  $selec value=\"$value\">" . $texto . "</option>";	

       }
	   
	   
       ///Return < option HTML TAG   
	   //Retorna a tag "option" do select
	   public static function populateCombo2($value, $texto, $sel=""){
		
		$selec = $value == $sel  ?" selected " : "";
		
		return "<option $selec value=\"$value\">" . $texto . "</option>";
	   }

//Show double dropdownlist. List of parameters: 
//Motra o duplo dropdownlist, estas são a lista dos parametros:
//1 - $lista1 : Array of results ($key=>$value) to be showed on left dropdown  / Array de resultados (do tipo $key=>$value) para serem exibidos no combobox da esquerda.
//2 - $lista2 : Array of results ($key=>$value) to be showed on right dropdown  / Array de resultados (do tipo $key=>$value) para serem exibidos no combobox da direita.
//3 - $campoid: Name of field, from array of results, that contains ID (option's value) / Nome do campo, do array de resultados, que representea o identificador, ou seja, o valor que vai ficar no "value" da tag option.
//4 - $campoTexto: Name of field, from array of results, that contains TEXT to show / Nome do campo, do array de resultados, que representea o texto, que será exibido na tag option.
//5 - $campoGrupo: (can be empty / pode ser vazio):  Name of field, from array of results, that contains Group Value (if you want to use optgroup) / Nome do campo, do array de resultados, que representea o agrupamento, ou seja, o valor que vai ficar no optgroup, caso queira usar este recurso.
//6-  $nomeCombo1: Name and ID of Left DropDown. Usefull to use this class more than 1 time at same page / Nome e ID do dropdown da esquerda.. útil pois podemos usar duplo combobox mais de uma vez na mesma página.
//7-  $nomeCombo2: Name and ID of Right DropDown. Usefull to use this class more than 1 time at same page / Nome e ID do dropdown da direita.. útil pois podemos usar duplo combobox mais de uma vez na mesma página.
//8-  $hdTemp: Name and ID of Hidden Field.. this field keep, temporarily, values while transfering between dropdowns.  / ID do campo hidden, usado para armazenar, temporariamente, valores enquanto transfere entre os combos.
//9- $height (default 220px) : Height size of both (left and right) dropdownlist - Permite configurar a altura dos dropdownlist     
//10-  $titleAvaliable: Title to show above left dropdownList   / Título a ser exibido acima do combo da esquerda
//10-  $titleSelected: Title to show above right dropdownList   / Título a ser exibido acima do combo da direita

static function showDoubleDropDown(array $lista1,array $lista2, $campoid, $campoTexto, $campoGrupo, 
       $nomeCombo1, $nomeCombo2, $hdTemp, $height = "220px", $titleAvaliable = "Disponível(is)", $titleSelected = "Selecionado(s)"){

?>
<table style="text-align:left ;width:96%">
	  <tr>
	    <td  class="f-tabela-lista" style="width:45%"><span> <?= $titleAvaliable ?></span><br>
				 <select name="<?= $nomeCombo1 ?>" id="<?= $nomeCombo1 ?>"
	multiple="multiple" style="width: 100%; height: <?= $height ?>;" 
					onClick="return false"
					onDblClick="moveSelectedOptionsAlert(this.form['<?= $nomeCombo1 ?>'],this.form['<?= $nomeCombo2 ?>'],true,this.form['<?= $hdTemp ?>'].value)">
                 <?php
			        $arr = 	$lista1;
	                if ( $campoGrupo != "" ){
		                  RendDoubleSelect::loadDropDownOptGroup($arr,$campoid,$campoTexto,$campoGrupo, "");
						}else{
							RendDoubleSelect::loadDropDownArray($arr, $campoid, $campoTexto, "");
						}
				?>
				 </select> 
				 </td>
				 <td style="width:10%" align="center">
				
			  <input type="hidden" name="<?= $hdTemp ?>" value="">	
				
	<INPUT TYPE="button" style="width:48px" class="botao" NAME="right" VALUE=" &gt; "
			    title="Select Item" ONCLICK="moveSelectedOptionsAlert(this.form['<?= $nomeCombo1 ?>'],this.form['<?= $nomeCombo2 ?>'],true,this.form['<?= $hdTemp ?>'].value)">
              <br>
	<INPUT TYPE="button" style="width:48px" class="botao" NAME="right" VALUE="&gt;&gt;" title="Select All" ONCLICK="moveAllOptions(this.form['<?= $nomeCombo1 ?>'],this.form['<?= $nomeCombo2 ?>'],true,this.form['<?= $hdTemp ?>'].value)">
              <BR>
	<INPUT TYPE="button" style="width:48px" class="botao" NAME="left" VALUE=" &lt; " title="Remove Item" ONCLICK="moveSelectedOptionsAlert(this.form['<?= $nomeCombo2 ?>'],this.form['<?= $nomeCombo1 ?>'],true,this.form['<?= $hdTemp ?>'].value)">
              <br>
	<INPUT TYPE="button" style="width:48px" class="botao" NAME="left" VALUE="&lt;&lt;" title="Remove All" ONCLICK="moveAllOptions(this.form['<?= $nomeCombo2 ?>'],this.form['<?= $nomeCombo1 ?>'],true,this.form['<?= $hdTemp ?>'].value)">	
			  
			           
				 </td>
				 <td class="f-tabela-lista" style="width:45%">
				 <span><?= $titleSelected ?></span><br>
				 <!-- <select id="<?= $nomeCombo2 ?>" name="exames" size="5" style="width: 100%; height: <?= $height ?>;" multiple onDblClick="moveSelectedOptionsAlert(this.form['<?= $nomeCombo2 ?>'],this.form['<?= $nomeCombo1 ?>'],true,this.form['<?= $hdTemp ?>'].value)" > -->
	<select name="selecionados[]" id="<?= $nomeCombo2 ?>" multiple style="width: 100%; height: <?= $height ?>;" onDblClick="moveSelectedOptionsAlert(this.form['<?= $nomeCombo2 ?>'],this.form['<?= $nomeCombo1 ?>'],true,this.form['<?= $hdTemp ?>'].value)">
                  <?php
			        $arr =  $lista2;
					
					
				if ( $campoGrupo != "" ){
					RendDoubleSelect::loadDropDownOptGroup($arr,$campoid,$campoTexto,$campoGrupo, "");
				}else{
					RendDoubleSelect::loadDropDownArray($arr, $campoid, $campoTexto, "");
				}
				?>
				
				
				</select>
	     
               
				 </td>
			  </tr>
	</table><?php
	}

static function showDoubleDropDownAlert(array $lista1, array $lista2, $campoid, $campoTexto, $campoGrupo, 
       $nomeCombo1, $nomeCombo2, $hdTemp, $height = "220px", $titleAvaliable = "Disponível(is)", $titleSelected = "Selecionado(s)"){

?>
<table style="text-align:left ;width:96%">
	  <tr>
	    <td  class="f-tabela-lista" style="width:45%"><span style="float:left"><b> <?= $titleAvaliable ?> </b></span> <div style="margin-top:2px;float:left; margin-left:10px; height:10px; width:10px; background-color:#f33"></div> <div style="float:left; margin-left:5px;"><span style="font-size:12px; color:#565656;">(Estoque baixo)</span></div><br>
				 <select name="<?= $nomeCombo1 ?>" id="<?= $nomeCombo1 ?>"
	multiple="multiple" style="width: 100%; height: <?= $height ?>;" 
					onClick="return false"
					onDblClick="moveSelectedOptionsAlert(this.form['<?= $nomeCombo1 ?>'],this.form['<?= $nomeCombo2 ?>'],true,this.form['<?= $hdTemp ?>'].value)">
                 <?php
			        $arr = 	$lista1;
	                if ( $campoGrupo != "" ){
		                  RendDoubleSelect::loadDropDownOptGroup($arr,$campoid,$campoTexto,$campoGrupo, "");
						}else{
							RendDoubleSelect::loadDropDownArray($arr, $campoid, $campoTexto, "");
						}
				?>
				 </select> 
				 </td>
				 <td style="width:10%" align="center">
				
			  <input type="hidden" name="<?= $hdTemp ?>" value="">	
				
	<INPUT TYPE="button" style="width:48px" class="botao" NAME="right" VALUE=" &gt; "
			    title="Select Item" ONCLICK="moveSelectedOptionsAlert(this.form['<?= $nomeCombo1 ?>'],this.form['<?= $nomeCombo2 ?>'],true,this.form['<?= $hdTemp ?>'].value)">
              <br>
	<!-- <INPUT TYPE="button" style="width:48px" class="botao" NAME="right" VALUE="&gt;&gt;" title="Select All" ONCLICK="moveAllOptions(this.form['<?= $nomeCombo1 ?>'],this.form['<?= $nomeCombo2 ?>'],true,this.form['<?= $hdTemp ?>'].value)"> -->
              <BR>
	<INPUT TYPE="button" style="width:48px" class="botao" NAME="left" VALUE=" &lt; " title="Remove Item" ONCLICK="moveSelectedOptionsAlert(this.form['<?= $nomeCombo2 ?>'],this.form['<?= $nomeCombo1 ?>'],true,this.form['<?= $hdTemp ?>'].value)">
              <br>
	<!-- <INPUT TYPE="button" style="width:48px" class="botao" NAME="left" VALUE="&lt;&lt;" title="Remove All" ONCLICK="moveAllOptions(this.form['<?= $nomeCombo2 ?>'],this.form['<?= $nomeCombo1 ?>'],true,this.form['<?= $hdTemp ?>'].value)">	 -->
			  
			           
				 </td>
				 <td class="f-tabela-lista" style="width:45%">
				 <span><b><?= $titleSelected ?></b></span><br>
				 <!-- <select id="<?= $nomeCombo2 ?>" name="exames" size="5" style="width: 100%; height: <?= $height ?>;" multiple onDblClick="moveSelectedOptionsAlert(this.form['<?= $nomeCombo2 ?>'],this.form['<?= $nomeCombo1 ?>'],true,this.form['<?= $hdTemp ?>'].value)" > -->
	<select name="selecionados[]" id="<?= $nomeCombo2 ?>" multiple style="width: 100%; height: <?= $height ?>;" onDblClick="moveSelectedOptionsAlert(this.form['<?= $nomeCombo2 ?>'],this.form['<?= $nomeCombo1 ?>'],true,this.form['<?= $hdTemp ?>'].value)">
                  <?php
			        $arr =  $lista2;
					
					
				if ( $campoGrupo != "" ){
					RendDoubleSelect::loadDropDownOptGroup($arr,$campoid,$campoTexto,$campoGrupo, "");
				}else{
					RendDoubleSelect::loadDropDownArray($arr, $campoid, $campoTexto, "");
				}
				?>
				
				
				</select>
	     
               
				 </td>
			  </tr>
	</table><?php
	} 
}
	
	

	?>