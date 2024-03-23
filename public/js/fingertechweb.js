

// 	$.ajax({

// 		url: 'http://localhost:9000/apiservice/capture-hash',
// 		type: 'GET',
// 		success: function (data) {

// 			if (data != "" && data != null) {
// 				$("#inputTemplate").val(data);
// 				localStorage.finger = data
// 				alert("Digital capturada com sucesso!");
// 			}
// 			else {
// 				alert("Digital não pode ser capturada!");
// 			}
// 		}
// 	})
// }

// /*********************************************
// * Nome: Enroll
// * Descrição: Chama o método "Enroll" da aplicação desktop, 
// * responsável por chamar a tela de captura de impressão digital para mais de um dedo.
// * Este método é recomendável quando você deseja capturar a impressão digital de mais de um dedo e
// * quando é necessário identificar a qual dedo esta digital pertence. 
// * Quando houver a captura de mais de uma impressão digital, elas serão armazenadas de maneira 
// * codificada no mesmo "Template" (String), mas durante a comparação qualquer dedo poderá ser 
// * comparado.
// * Retorno: Template (String) ou "" (Vazio)
// *********************************************/
// function Enroll() {

// 	$.ajax({

// 		url: 'http://localhost:9000/api/public/v1/captura/Enroll/1',
// 		type: 'GET',
// 		success: function (data) {

// 			if (data != "" && data != null) {
// 				$("#inputTemplate").val(data);
// 				alert("Digitais capturadas com sucesso!");
// 			}
// 			else {
// 				alert("Digital não pode ser capturada!");
// 			}
// 		}
// 	})
// }

// /*********************************************
// * Nome: Match
// * Descrição: Chama o método "VerifyMatch" da aplicação desktop, 
// * responsável por chamar a tela de captura de digital para apenas um único dedo e realizar a 
// * comparação com um outro template (impressão digital) já cadastrada.
// * Este método é recomendável quando você deseja você comparação de 1:1 (Um para Um). 
// * Retorno: Template (String) ou Null
// *********************************************/
// function Match(digital) {

// 	if (digital != "") {

// 		$.ajax({
// 			url: 'http://localhost:9000/apiservice/match-one-on-one',
// 			type: 'POST',
// 			data: {
// 				template: digital
// 			},
// 			success: function (data) {

// 				if (data != "") {
// 					alert("Digital encontrada com sucesso!");
// 				}
// 				else {
// 					alert("Digitais não conferem.");
// 				}
// 			}
// 		});
// 	}
// 	else {
// 		alert("Por favor, registre a impressão digital.");
// 	}
// }

// Swal.fire("teste")

// Função para capturar o hash
var ajax_header = {
	"Access-Control-Allow-Origin": '*',
	"Access-Control-Allow-Methods": "POST, GET, OPTIONS",
	// 'Content-Type': 'application/json',
	"Access-Control-Allow-Headers": "Authorization, Origin, X-Requested-With, Content-Type, Accept",
	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}

// $.ajaxSetup({
// 	headers: {
// 		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
// 	}
// });

function preCapture(event) {
	Swal.fire({
		title: 'Aguarde...',
		html: 'Procurando o Leitor Biométrico.',
		allowOutsideClick: false,
		didOpen: () => {
			Swal.showLoading();
			$.ajax({
				url: "https://localhost:9000/apiservice/capture-hash",
				type: "GET",
				headers: {
					"Access-Control-Allow-Origin": '*',
					"Access-Control-Allow-Methods": "POST, GET, OPTIONS",
					"Access-Control-Allow-Headers": "Authorization, Origin, X-Requested-With, Content-Type, Accept"
				},
				success: function (response) {
					img = document.getElementById("finger")
					if (response.success) {
						$("#template").val(response.template)
						img.src = img.src.replace("finger-read.svg","finger-ok.svg")
						document.getElementById("finger-text").innerText = "Biometria capturada, pronta para salvar"
						Swal.fire({
							icon: 'success',
							title: 'Sucesso!',
							text: 'Digital capturada com sucesso!'
						});

					} else {
						img.src = img.src.replace("finger-ok.svg","finger-read.svg")
						document.getElementById("finger-text").innerText = "Capturar biometria."
						Swal.fire({
							icon: 'info',
							title: 'Atenção!',
							text: 'Não foi possível capturar a digital'
						});
					}
				},
				error: function (xhr, status, error) {
					if (!xhr.status) {
						Swal.fire({
							icon: 'error',
							title: `Erro de resposta!`,
							text: "Não foi possível se conectar a rede da API, é necessário executar a API do leitor neste computador."
						});
					} else {

						errorCode = xhr.responseText.match(/\d+/g)

						Swal.fire({
							icon: 'info',
							title: `Atenção!`,
							text: errosMap[errorCode] ?? xhr.responseText
						});
					}
				}
			});
		}
	})
}

function captureHash(user_id) {
	Swal.fire({
		title: 'Aguarde...',
		html: 'Procurando o Leitor Biométrico.',
		allowOutsideClick: false,
		didOpen: () => {
			Swal.showLoading();
			$.ajax({
				url: "https://localhost:9000/apiservice/capture-hash",
				type: "GET",
				headers: {
					"Access-Control-Allow-Origin": '*',
					"Access-Control-Allow-Methods": "POST, GET, OPTIONS",
					"Access-Control-Allow-Headers": "Authorization, Origin, X-Requested-With, Content-Type, Accept"
				},
				success: function (response) {
					Swal.close();
					Swal.fire({
						html: "Cadastrando Biometria",
						allowOutsideClick: false,
						didOpen: () => {
							$.ajax({
								url: `${window.location.href}/biometria/salvar`,
								type: "post",
								headers: ajax_header,
								data: {
									template: response.template
								},
								success: function (response2) {
									Swal.close();
									Toast.fire({
										icon: "success",
										title: "Biometria cadastrada com sucesso."
									})
									loadToMemory([{id:response2.user.id, digital:response2.template}], true)

								},
								error: function (response2) {
									Toast.fire({
										icon: "error",
										title: "Erro ao tentar cadastrar biometria."
									})
								}

							})
						}
					})

					Swal.fire({
						icon: 'success',
						title: 'Sucesso!',
						text: 'Digital capturada com sucesso!'
					});
				},
				error: function (xhr, status, error) {
					Swal.close();
					errorCode = xhr.responseText.match(/\d+/g)

					Swal.fire({
						icon: 'info',
						title: `Atenção!`,
						text: errosMap[errorCode] ?? xhr.responseText
					});
				}
			});
		}
	})

}

// Função para identificar um indivíduo
function matchOneOnOne(digital) {
	template = {}
	template.template = digital
	if (digital != "") {
		// digital = JSON.parse(digital);
		$.ajax({
			url: 'https://localhost:9000/apiservice/match-one-on-one',
			type: 'POST',
			headers: {
				'Access-Control-Allow-Origin': '*',
				'Content-Type': 'application/json',
				'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
				'Access-Control-Allow-Headers': 'Authorization, Origin, X-Requested-With, Content-Type, Accept'
			},
			dataType: 'json',
			data: JSON.stringify(template),
			success: function (data) {
				if (data != "") {
					Swal.fire({
						icon: 'success',
						title: 'Sucesso!',
						text: 'Digital comparada com sucesso!'
					});
				} else {
					Swal.fire({
						icon: 'error',
						title: 'Erro!',
						text: 'Digital capturada não corresponde!'
					});
				}
			}, error: function (xhr, status, error) {

				Swal.fire({
					icon: 'info',
					title: `Atenção!`,
					text: "Não Foi possível identificar a digital"
				});
			}
		});
	} else {
		Swal.fire({
			icon: "info",
			title: "Atenção!",
			text: "Por favor registre a impressão digital"
		})
	}
}

// Função para identificação
function identification() {

	$.ajax({
		url: "https://localhost:9000/apiservice/identification",
		type: "GET",
		success: function (response) {
			console.log("Identificação realizada com sucesso:", response);
		},
		error: function (xhr, status, error) {
			console.error("Erro na identificação:", error);
		}
	});
}

// Função para carregar para a memória
function loadToMemory(finger_array, reload = false) {
	var template = [];
	finger_array.forEach((new_finger) => {
		finger = {};

		finger.id = new_finger.id;
		finger.template = new_finger.digital;
		template.push(finger);
	})

	console.log(template)
	if (template[0].template != "") {
		$.ajax({
			url: "https://localhost:9000/apiservice/load-to-memory",
			type: "POST",
			contentType: "application/json",
			headers: {
				'Access-Control-Allow-Origin': '*',
				'Access-Control-Allow-Methods': 'POST, GET, OPTIONS',
				'Access-Control-Allow-Headers': 'Authorization, Origin, X-Requested-With, Content-Type, Accept',
				'Content-Type': 'application/json',
			},
			dataType: 'json',
			data: JSON.stringify(template),
			success: function (response) {
				console.log(response)
				Toast.fire({
					icon: "success",
					title: "Biometria salva no dispositivo."
				});
				if (reload) {
					window.location.reload()
				}
			},
			error: function (xhr, status, error) {
				errorCode = xhr.responseText.match(/\d+/g)
				Toast.fire({
					icon: "info",
					title: errosMap[errorCode] ?? xhr.responseText
				});
			}
		});
	}
}

// Função para deletar todos da memória
function deleteAllFromMemory() {
	$.ajax({
		url: "https://localhost:9000/apiservice/delete-all-from-memory",
		type: "GET",
		headers: ajax_header,
		success: function (response) {
			console.log("Todos os registros deletados da memória:", response);
		},
		error: function (xhr, status, error) {
			console.error("Erro ao deletar todos da memória:", error);
		}
	});
}

function searcUser() {
	Swal.fire({
		title: 'Aguarde...',
		html: 'Procurando o Leitor Biométrico.',
		allowOutsideClick: false,
		didOpen: () => {
			Swal.showLoading();
			$.ajax({
				url: "https://localhost:9000/apiservice/identification",
				type: "GET",
				success: function (response) {
					if (response.success) {
						Swal.fire({
							position: "center",
							icon: "success",
							title: "Usuário localizado com sucesso!",
							showConfirmButton: false,
							timer: 1500,
							didClose: () => {
								window.location.href = `${window.location.origin}/dashboard/usuarios/${response.id}`
							}
						});
					} else {
						Swal.fire({
							icon: "info",
							title: "Atenção!",
							text: "Não foi possível identificar a biometria."
						})
					}
				},
				error: function (xhr, status, error) {
					if (!xhr.status) {
						Swal.fire({
							icon: 'error',
							title: `Erro de resposta!`,
							text: "Não foi possível se conectar a rede da API, é necessário executar a API do leitor neste computador."
						});
					} else {

						errorCode = xhr.responseText.match(/\d+/g)

						Swal.fire({
							icon: 'info',
							title: `Atenção!`,
							text: errosMap[errorCode] ?? xhr.responseText
						});
					}
				}
			});
		}
	})
}

function loadFromDatabase() {
	$.get(`${window.location.href}/download`).then((fingers) => {
		console.log(fingers)
		loadToMemory(fingers,false)
	})
}

function randomIntFromInterval(min, max) { // min and max included 
	return Math.floor(Math.random() * (max - min + 1) + min)
}

errosMap = {
	"261": "Leitor Biométrico não localizado",
	"513": "Operação cancelada pelo usuário",
	"1287": "Biometria existente no leitor"
}
const Toast = Swal.mixin({
	toast: true,
	position: "top-end",
	showConfirmButton: false,
	timer: 3000,
	timerProgressBar: true,
	didOpen: (toast) => {
		toast.onmouseenter = Swal.stopTimer;
		toast.onmouseleave = Swal.resumeTimer;
	}
});
