<?php
	if ((! isset($categorie_id)) || ("" == $categorie_id))
		$categorie_id = "_";
?><form id="arborescence" action="" method="post">
<input type="hidden" name="op" id="arbo_op" value="">
<input type="hidden" name="categorie_id" id="arbo_cat_id" value="">
</form>
<div id="contenu">
</div>
<script>
	function arbo_traite(select) {
		categorie_mere = $('#'+select).data('id');
		val = $('#'+select).val();
		if ("" == val) {
			// ne rien faire
		}
		else if ('gorubchg' == val) {
			$('#contenu').empty().append('<h2>Modification d\'une catégorie</h2>');
			$('#arborescence').attr('action','../c/');
			$('#arbo_op').val('');
			$('#arbo_cat_id').val(categorie_mere);
			$('#arborescence').submit();
		}
		else if ('gorubadd' == val) {
			$('#contenu').empty().append('<h2>Ajout d\'une catégorie</h2>');
			$('#arborescence').attr('action','../c/');
			$('#arbo_op').val('catadd');
			$('#arbo_cat_id').val(categorie_mere);
			$('#arborescence').submit();
		}
		else if ('goartlst' == val) {
			$('#contenu').empty().append('<h2>Liste des articles</h2>');
			document.location = '../p/?categorie_id='+categorie_mere;
		}
		else if ('goartadd' == val) {
			$('#contenu').empty().append('<h2>Ajout d\'un article</h2>');
			$('#arborescence').attr('action','../p/');
			$('#arbo_op').val('postadd');
			$('#arbo_cat_id').val(categorie_mere);
			$('#arborescence').submit();
		}
		else if ('golnklst' == val) {
			$('#contenu').empty().append('<h2>Liste des liens</h2>');
			document.location = '../lien/?categorie_id='+categorie_mere;
		}
		else if ('golnkadd' == val) {
			$('#contenu').empty().append('<h2>Ajout d\'un lien</h2>');
			$('#arborescence').attr('action','../lien/');
			$('#arbo_op').val('linkadd');
			$('#arbo_cat_id').val(categorie_mere);
			$('#arborescence').submit();
		}
		else {
			ajoute_selection(val,val);
			$('#contenu').empty().append('<h2>Détail de la catégorie</h2>');
		}
	}
	function ajoute_selection(rub_mere,rub_actuelle) {
		// console.log(rub_mere);
		// console.log(rub_actuelle);
		$('#selectniv'+rub_mere.length).remove();
		$.getJSON('../../ajax/admin/c/souscategories.php',{'c':rub_mere},function (data) {
			// console.log(data);
			select = '<span id="selectniv'+rub_mere.length+'"><select id="select'+rub_mere+'" data-id="'+rub_mere+'" onchange="arbo_traite(\'select'+rub_mere+'\');"><option></option>';
			options = '';
			for (i=0; i < data.length; i++) {
				rub_id = data[i].id;
				rub_label = data[i].label;
				if (rub_id == rub_actuelle.substr(0,rub_id.length)) {
					// console.log(rub_id);
					// console.log(rub_actuelle);
					options += '<option selected="selected" value="'+rub_id+'">'+rub_label+'</option>';
				}
				else {
					options += '<option value="'+rub_id+'">'+rub_label+'</option>';
				}
			}
			if ('' != rub_mere) {
				options += '<option value="gorubchg">Modifier la catégorie</option>';
				options += '<option value="gorubadd">Ajouter une catégorie</option>';
				options += '<option value="goartlst">Liste des articles</option>';
				options += '<option value="goartadd">Ajouter un article</option>';
				options += '<option value="golnklst">Liste des liens</option>';
				options += '<option value="golnkadd">Ajouter un lien</option>';
			}
			select += options+'</select></span>';
			mere = rub_mere.substr(0,rub_mere.length-1);
			if ('' == mere) {
				$('#arborescence').append(select);
			}
			else {
				$('#select'+mere).after(select);
			}
			// console.log(select);
		});
	}
	$(document).ready(function() {
		rubrique_id = '<?php print($categorie_id); ?>';
		ajoute_selection('',rubrique_id);
		for (i = 0; i < rubrique_id.length; i++)
		{
			ajoute_selection(rubrique_id.substr(0,i+1),rubrique_id);
		}
	});
</script>
