
var ajax_header = {
	"Access-Control-Allow-Origin": '*',
	"Access-Control-Allow-Methods": "POST, GET,DELETE, OPTIONS",
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
						img.src = img.src.replace("finger-read.svg", "finger-ok.svg")
						document.getElementById("finger-text").innerText = "Biometria capturada, pronta para salvar"
						Swal.fire({
							icon: 'success',
							title: 'Sucesso!',
							text: 'Digital capturada com sucesso!'
						});

					} else {
						img.src = img.src.replace("finger-ok.svg", "finger-read.svg")
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
									template: response.template,
									id: user_id
								},
								success: function (response2) {
									Swal.close();
									console.log(response)
									Toast.fire({
										icon: "success",
										title: "Biometria cadastrada com sucesso."
									})
									loadToMemory([{ id: response2.user.id, digital: response2.template }], true)

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
	var verified = false
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
					verified = true
					Swal.fire({
						icon: 'success',
						title: 'Sucesso!',
						text: 'Digital comparada com sucesso!'
					})
				} else {
					Swal.fire({
						icon: 'error',
						title: 'Erro!',
						text: 'Digital capturada não corresponde!'
					})
				}
			}, error: function (xhr, status, error) {
				if (!xhr.status) {
					Swal.fire({
						icon: 'error',
						title: `Atenção!`,
						text: "Não Foi possível identificar a digital."
					});
				} else {
					errorCode = xhr.responseText.match(/\d+/g) ?? xhr.responseJSON.message;
					Swal.fire({
						icon: 'info',
						title: `Atenção!`,
						text: errosMap[errorCode] ?? xhr.responseText
					});
				}
			}
		});
	} else {
		Swal.fire({
			icon: "info",
			title: "Atenção!",
			text: "Por favor registre a impressão digital"
		})
	}
	return verified
}
function matchOneOnOne2(digital) {
	return new Promise((resolve, reject) => {
		var verified = false;
		template = {};
		template.template = digital;
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
						verified = true;
						Swal.fire({
							icon: 'success',
							title: 'Sucesso!',
							text: 'Digital comparada com sucesso!'
						});
						resolve(data);
					} else {
						Swal.fire({
							icon: 'error',
							title: 'Erro!',
							text: 'Digital capturada não corresponde!'
						});
						reject(new Error('Digital capturada não corresponde!'));
					}
				},
				error: function (xhr, status, error) {
					if (!xhr.status) {
						Swal.fire({
							icon: 'error',
							title: `Atenção!`,
							text: "Não Foi possível identificar a digital."
						});
					} else {
						errorCode = xhr.responseText.match(/\d+/g) ?? xhr.responseJSON.message;
						Swal.fire({
							icon: 'error',
							title: `Atenção!`,
							text: errosMap[errorCode] ?? xhr.responseText
						});
					}
					reject(new Error('Erro na requisição AJAX'));
				}
			});
		} else {
			Swal.fire({
				icon: "info",
				title: "Atenção!",
				text: "Por favor registre a impressão digital"
			});
			reject(new Error('Digital não registrada'));
		}
	});
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

function searchUser() {
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

function searchEmployeeByUserId() {
	Swal.fire({
		title: 'Aguarde...',
		html: 'Procurando o Leitor Biométrico.',
		allowOutsideClick: false,
		didOpen: () => {
			Swal.showLoading();
			$.ajax({
				url: "https://localhost:9000/apiservice/identification",
				type: "GET",
				success: async function (response) {
					if (response.success) {
						employee = await $.get(`${window.location.href}/${response.id}/colaborador`)
						Swal.fire({
							position: "center",
							icon: "success",
							title: "Usuário localizado com sucesso!",
							showConfirmButton: false,
							timer: 1500,
							didClose: () => {
								window.location.href = `${window.location.href}/${employee.id}/formularios`
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

async function getAuthBiometric() {
	Swal.fire({
		title: "Carregando sua biometria.",
		text: "É necessário confimrar sua identidade biométrica.",
		showConfirmButton: false,
		didOpen: () => {
			Swal.showLoading()
			$.ajax({
				url: `${window.location.href}/bioauth`,
				type: "GET",
				success: function (response) {
					if (response.success) {
						matchOneOnOne2(response.template).then((response) => {
							if (response) {
								getUsersAvailable()
							}
						}).catch((error) => {
							console.error("error: ", error)
						})

					} else {
						Swal.fire({
							title: "Erro",
							text: "Não foi possível resgatar sua biometria.",
							icon: "info",
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
			})
		}
	})
}

async function checkAuthBiometry() {

}

async function getAuthBiometry() {
	const data = await $.ajax({
		url: `${window.location.origin}/dashboard/biometria/bioauth`,
		method: 'GET'
	});
	return data;
}

async function getEmployeeBiometry(id) {
	const data = await $.ajax({
		url: `${window.location.origin}/dashboard/biometria/colaborador/${id}`,
		method: 'GET'
	});
	return data;
}

function deleteUserFromMemory(user_id, bio_id) {
	if (bio_id > 0) {
		Swal.fire({
			title: "Deletar Biometria",
			icon: "info",
			text: "Esta ação apagará a biometria do sistema",
			showCancelButton: true,
			confirmButtonText: "Apagar biometria",
			preConfirm: (result) => {
				console.log(result)
				Swal.showLoading()
				$.ajax({
					url: `${window.location.href}/${bio_id}/delete`,
					type: "DELETE",
					headers: ajax_header,
					success: function (response) {
						if (response.success) {
							$.ajax({
								url: `https://localhost:9000/apiservice/remove-user-from-memory/${response.id}`,
								type: "GET",
								headers: ajax_header,
								success: function () {
									Swal.fire({
										title: "Deletar Digital",
										icon: "success",
										text: "Digital removida do dispositivo com sucesso."
									}).then(() => {
										window.location.reload()
									})
								},
								error: function (xhr, status, error) {
									if (!xhr.status || xhr.status == 404) {
										Swal.fire({
											icon: 'error',
											title: `Erro de resposta!`,
											text: "Não foi possível se conectar a rede da API, é necessário executar a API do leitor neste computador."
										}).then(() => {
											window.location.reload()
										});
									} else {
										errorCode = xhr.responseText.match(/\d+/g) ?? xhr.responseJSON.message;
										errorText = errosMap[errorCode] ?? xhr.responseText
										Swal.fire({
											icon: 'info',
											title: `Atenção!`,
											text: `não foi possível remover a biometria do dispositivo,<p>Erro:
											 ${errorText}</p>`
										}).then(() => {
											window.location.reload()
										});
									}
								}
							});
						} else {

						}
					}
				})
			},
		})
	} else {

	}

}

function loadFromDatabase() {
	$.get(`${window.location.href}/download`).then((fingers) => {
		// console.log(fingers.length)
		if (fingers.length > 0) {
			deleteAllFromMemory()
			loadToMemory(fingers, false)
		} else {
			Swal.fire("Biometrias", "Não há dados biométricos no banco de dados", "info")
		}
	})
}

function getUsersAvailable() {
	Swal.fire({
		title: 'Selecione um usuário',
		html: `'<div class="form-group">
		<select class="form-control" id="list-users">
		</select>
		</div>`,
		allowOutsideClick: false,
		showConfirmButton: true,
		showCancelButton: true,
		confirmButtonText: "Confirmar",
		cancelButtonText: "cancelar",
		didOpen: () => {
			$.get(`${window.location.href}/usuarios`).then((data) => {
				if (data.count) {
					for (const key in data.users) {
						if (Object.hasOwnProperty.call(data.users, key)) {
							$("#list-users").append(new Option(
								data.users[key].name,
								data.users[key].id));
						}
					}
					// $("#list-users").select2()
				}

			})
		}
	}).then((result) => {
		if (result.isConfirmed) {
			id = $("#list-users").val()
			if (!isNaN(id)) {
				console.log(`cadastrar: ${id}`)
				captureHash(id)
			}
		}
	})
}

function randomIntFromInterval(min, max) { // min and max included 
	return Math.floor(Math.random() * (max - min + 1) + min)
}

errosMap = {
	"261": "Leitor Biométrico não localizado",
	"513": "Operação cancelada pelo usuário",
	"1287": "Biometria existente no leitor",
	"Timeout": "Tempo de espera foi excedido!, não foi possível identificar a digital"
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
