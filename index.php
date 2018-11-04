<?php

	$retorno = "";

	function curl($dados = "", $tipo = "", $meta = "", $GET = false, $GETUSER = false) {

		if ($GET) {
			if ($GETUSER) {
				// se $GETUSER == true retnora o GET USER somente o user especifico
				if ($dados != "") {
					// se dados diferente de vazio
					// url de teste da requisição
					$curl = curl_init($_SERVER['HTTP_HOST'] . $_SERVER ['REQUEST_URI'] . "/get.php/user/" . $dados);
				} else {
					// se dados for vazio
					return false;
				}
			} else {
				// se $GETUSER == false retorna o GET USERS lista todos
				$curl = curl_init($_SERVER['HTTP_HOST'] . $_SERVER ['REQUEST_URI'] . "/get.php/users");
			}
		} else {
			if ($dados != "") {
				// se dados diferente de vazio
				// url de teste da requisição
				$curl = curl_init($_SERVER['HTTP_HOST'] . $_SERVER ['REQUEST_URI'] . "/get.php/users");
			} else {
				// se dados for vazio
				return false;
			}
		}

		if ($tipo == "DELETE") {
			if ($dados != "") {
				// se dados diferente de vazio
				// url de teste da requisição
				$curl = curl_init($_SERVER['HTTP_HOST'] . $_SERVER ['REQUEST_URI'] . "/get.php/user/" . $dados);
			} else {
				// se dados for vazio
				return false;
			}
		}

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		/* PARA METODOS POST, PUT e DELETE */
		if (!$GET) curl_setopt($curl, $meta, $tipo);
		if (!$GET) curl_setopt($curl, CURLOPT_POSTFIELDS, $dados);

		//curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));

		$curl_response = curl_exec($curl);
		curl_close($curl);

		if ($tipo != "") {
			echo "Tipo = " . $tipo . "<br>CURL = " . $curl;
		} else {
			echo "Tipo = GET<br>CURL = " . $curl;
		}

		return $curl_response;

	}

	if ($_POST) {
		//$dados = $_POST['dados'];
		switch ($_POST['metodo']) {

			case 'GETs':
				$retorno = curl("", "", "", true);
			break;
			
			case 'GET': {
				if ($_POST['id'] != "") {
					$data = array(
						'id' => $_POST['id']
					);
					$retorno = curl($_POST['id'], "", "", true, true);
				} else {
					$retorno = "Not Found.";
				}
			}break;
			
			case 'POST': {
				if ($_POST['name'] != "" && $_POST['email'] != "" && $_POST['telefone'] != "" && $_POST['address'] != "") {
					$data = array(
						'name' => $_POST['name'],
						'email' => $_POST['email'],
						'telefone' => $_POST['telefone'],
						'address' => $_POST['address']
					);
					$retorno = curl(json_encode($data), "POST", CURLOPT_POST);
				} else {
					$retorno = "Not Found.";
				}
				//$retorno = curl($_POST['dados'], "POST", CURLOPT_POST);
			}break;
			
			case 'PUT': {
				if ($_POST['id'] != "") {
					$data = array(
						'id' => $_POST['id'],
						'name' => $_POST['name'],
						'email' => $_POST['email'],
						'telefone' => $_POST['telefone'],
						'address' => $_POST['address']
					);
					//$retorno = curl($_POST['dados'],"PUT",CURLOPT_CUSTOMREQUEST);
					$retorno = curl(json_encode($data), "PUT", CURLOPT_CUSTOMREQUEST);
				} else {
					$retorno = "Not Found.";
				}
			}break;
			
			case 'DELETE': {
				if ($_POST['id'] != "") {
					$retorno = curl($_POST['id'], "DELETE", CURLOPT_CUSTOMREQUEST);
				} else {
					$retorno = "Not Found.";
				}
			}break;
		
		}

	}
	
?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Language" content="pt-br">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=yes' name='viewport'>
	<title></title>
	<link rel="stylesheet" href="src/css/bootstrap.min.css">
</head>
<body>

<div class="container">
	<div class="row">
		<div class="col-12">
			
			<form action="<?= $_SERVER ['REQUEST_URI'] ?>" method="POST">
				<center>
					<table style="margin-top: 15px;">
						<tr>
							<td valign="TOP">
								<div class="form-group">
									<div class="input-group">
									    <div class="input-group-prepend">
									    	<input id="send" class="btn btn-dark" style="border-bottom-left-radius: .25rem; border-top-left-radius: .25rem;" onclick="document.getElementById('met').value" type="submit" value="SEND">
									    </div>
									    <select id="met" name="metodo" class="form-control">
									    	<option selected>Select Method</option>
											<option value="GETs">GET USER's</option>
											<option value="GET">GET USER</option>
											<option value="POST">POST</option>
											<option value="PUT">PUT</option>
											<option value="DELETE">DELETE</option>
										</select>
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td valign="TOP">
								<div class="form-group input id">
									Id: <input type="text" class="form-control" name="id" id="id">
								</div>
								<div class="form-group input name">
									Nome: <input type="text" class="form-control" name="name" id="name">
								</div>
								<div class="form-group input email">
									Email: <input type="text" class="form-control" name="email" id="email">
								</div>
								<div class="form-group input telefone">
									Telefone: <input type="text" class="form-control" name="telefone" id="telefone">
								</div>
								<div class="form-group input address">
									Endereço: <input type="text" class="form-control" name="address" id="address">
								</div>
								<div class="form-group">
									<textarea class="form-control retorno" placeholder="Return" style="width:500px; height:200px;" disabled="disabled"><?php echo $retorno; ?></textarea>
								</div>
							</td>
						</tr>
					</table>
				</center>
			</form>

		</div>
	</div>
</div>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
	
	$('.input').css('display', 'none');

	$('#send').on('click', function() {
		if ($('#met').val() == "DELETE") {
			var confirma = confirm("Deseja deletar ?");
			if (confirma != true) {
				return false;
			}
		}
		if ($('#met').val() == "POST") {
			var confirma = confirm("Deseja salvar ?");
			if (confirma != true) {
				return false;
			}
		}
		if ($('#met').val() == "PUT") {
			var confirma = confirm("Deseja atualizar ?");
			if (confirma != true) {
				return false;
			}
		}
	});

	$('#met').on('change', function() {
		if ($('#met').val() == "GETs") {

			$('.input').css('display', 'none');
			$('.retorno').val('');
			console.log($('#met').val());

		} else if ($('#met').val() == "GET") {

			$('.input').css('display', 'none');
			$('.id').css('display', 'block');
			$('.retorno').val('');
			console.log($('#met').val());

		} else if ($('#met').val() == "POST") {

			$('.input').css('display', 'none');
			$('.name').css('display', 'block');
			$('.email').css('display', 'block');
			$('.telefone').css('display', 'block');
			$('.address').css('display', 'block');
			$('.retorno').val('');
			console.log($('#met').val());

		} else if ($('#met').val() == "PUT") {

			$('.input').css('display', 'block');
			$('.retorno').val('');
			console.log($('#met').val());

		} else if ($('#met').val() == "DELETE") {

			$('.input').css('display', 'none');
			$('.id').css('display', 'block');
			$('.retorno').val('');
			console.log($('#met').val());

		} else {
			$('.input').css('display', 'none');
			$('.retorno').val('');
			console.log($('#met').val());
		}
	});

</script>

</body>
</html>