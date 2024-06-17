$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        "Authorization": `Bearer ${$("meta[name='api_token']").attr("content")}`
    }
});
var data_form = [];
var table_products;

//cadastro de notas
function createInvoice(url, api_token, next_url) {
    $("#value,#value_departament").inputmask('remove');

    formData = new FormData(document.getElementById("createInvoiceForm"));
    inputs = document.querySelectorAll("input")
    selects = document.querySelectorAll("select")
    inputs.forEach((e) => {
        e.classList.remove("is-invalid")
        e.parentElement.lastElementChild.classList.remove("text-danger")
    })
    selects.forEach((e) => {
        e.classList.remove("is-invalid")
        e.parentElement.lastElementChild.classList.remove("text-danger")
    })
    $.ajax({
        url: url,
        type: 'POST',
        headers: { "Authorization": `Bearer ${$("meta[name='api_token']").attr("content")}` },
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            if (response.success) {

                Swal.fire({
                    title: "Cadastro de notas",
                    text: "Nota cadastrada com sucesso!",
                    icon: "success"
                }).then(function () {
                    Swal.fire({
                        title: "Cadastro de produtos",
                        text: "Deseja cadastrar os produtos para a nota criada?",
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonText: "Quero adicionar.",
                        cancelButtonText: "Não, talvez mais tarde."
                    }).then((result) => {
                        if (result.isConfirmed) {
                            closeModal('createInvoices');
                            openModal('createInvoiceProducts')
                            console.log(response)
                            getProducts(next_url, $("meta[name='api_token']").attr("content"))
                            $("#invoice_route").val(response.invoice_route)
                        }
                    })
                });
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            if (!jqXHR.responseJSON.success) {
                for (error in jqXHR.responseJSON.errors) {
                    element = document.getElementById(`${error}`)
                    console.log(error)
                    element.classList.add("is-invalid")
                    element.parentElement.lastElementChild.classList.remove("text-muted")
                    element.parentElement.lastElementChild.classList.add("text-danger")
                    element.parentElement.lastElementChild.innerHTML = jqXHR.responseJSON.errors[error]
                }
            }
            Swal.fire({
                title: "Cadastro de notas.",
                text: jqXHR.responseJSON.message,
                icon: 'warning'
            }).then(() => console.log("encerrou o erro"))
        }
    });
}

function createInvoiceProducts(url = null) {
    $("#value_unid").inputmask('remove');
    array = []

    data_form.forEach((e, i) => {
        produtos = {}
        for (key in data_form[i]) {
            produtos[key] = data_form[i][key]
            console.log(i)
        }
        array.push(produtos)
    })
    Swal.fire({
        title: "enviando produtos",
        html: `<div id='response'>Aguarde...</div>`,
        didOpen: () => {
            Swal.showLoading()
            $.ajax({
                method: "POST",
                url: $("#invoice_route").val(),
                contentType: 'application/json; charset=utf-8',
                dataType: 'json',
                data: JSON.stringify({ data: array }),
                headers: { "Authorization": `Bearer ${$("meta[name='api_token']").attr("content")}` },
                success: (response) => {
                    console.log(response)
                    if (response.success) {
                        Swal.fire({
                            icon: response.type,
                            title: response.message,
                            text: response.event,
                            footer: response.footer
                        }).then(() => {
                            window.location.reload()
                        })

                    } else {
                        Swal.fire({
                            icon: response.type,
                            title: response.message,
                            text: response.event,
                            footer: response.footer
                        })
                    }
                }
            })
        }

    })
    // form.submit();
}
function getProducts(url, api_token) {
    table_products = document.getElementById("produts_table")
    $("#invoiceProductsForm #product_id").select2({
        ajax: {
            url: url,
            type: "GET",
            headers: { "Authorization": `Bearer ${$("meta[name='api_token']").attr("content")}` },
            dataType: 'json',
            delay: 250,
            dropdownParent: $("#createInvoiceProducts"),
            data: function (params) {
                return {
                    q: params.term, // search term
                };
            },
            processResults: function (response) {
                let products = response.map(function (e) {
                    return {
                        "id": e.id,
                        "text": `${e.description} - TAM: ${e.size} - MATERIAL: ${e.material} - CARAC.: ${e.characteristics}`
                    }
                })

                return {
                    results: products
                };
            },
            cache: true
        }
    });

    setTimeout(() => {
        dd = document.querySelector("#invoiceProductsForm > div > div:nth-child(1)")
        document.getElementById("select2-product_id-container").style.minWidth = `${0.85 * dd.clientWidth}px`
    }, 500)

}
$("#add").on("click", () => {
    array_product = []
    // new_product = $('#invoiceProductsForm').serializeArray();
    removeCurrencyMask('value_unid');
    new_product = new FormData(document.getElementById("invoiceProductsForm"))
    for (const [key, value] of new_product.entries()) {
        array_product[key] = value
    }
    console.log(array_product)
    validateProduct(new_product);
    data_form.push(array_product);
    setCurrencyValue(array_product['value_unid'])
    row = table_products.insertRow()
    cell = row.insertCell()
    cell.innerText = data_form.length
    cell = row.insertCell()
    icon = document.createElement('i')
    icon.classList.add("fa")
    icon.classList.add("fa-trash")
    icon.classList.add("text-danger")
    icon.setAttribute('aria-hidden', true)
    icon.setAttribute('product', data_form.length - 1)
    icon.style.cursor = "pointer"
    icon.addEventListener("click", (e) => {
        clearTable()
        data_form.splice(e.target.getAttribute("product"), 1)
        loadTable()
    })
    cell.append(icon)
    console.log(array_product)
    row.insertCell().innerText = array_product['qtd']
    row.insertCell().innerText = array_product['und']
    row.insertCell().innerText = array_product['name']
    row.insertCell().innerText = array_product['value_unid']
    row.insertCell().innerText = array_product['ca_number']
    // for (let index = 4; index < 9; index++) {
    //     cell = row.insertCell()
    //     cell.innerText = array_product[index]['value'];

    // }
    document.querySelector('span[id="total"]').innerText = data_form.length;
})

function removeItem(index_p) {
    console.log(data_form[index_p])
    console.log(data_form[index_p].name)
    clearTable()
    data_form.splice(index_p, 1)
    loadTable()
    document.querySelector('span[id="total"]').innerText = data_form.length;
}

function clearTable() {
    while (table_products.rows.length > 1) {
        table_products.deleteRow(1)
    }
    document.querySelector('span[id="total"]').innerText = data_form.length;
}

function loadTable() {
    data_form.forEach((element, i2) => {
        row = table_products.insertRow()
        cell = row.insertCell()
        cell.innerText = i2 + 1
        cell = row.insertCell()
        icon = document.createElement('i')
        icon.classList.add("fa")
        icon.classList.add("fa-trash")
        icon.classList.add("text-danger")
        icon.setAttribute('aria-hidden', true)
        icon.setAttribute('product', i2)
        icon.style.cursor = "pointer"
        icon.addEventListener("click", () => {
            removeItem(icon.getAttribute('product'), 1)
        })
        cell.append(icon)
        for (let i3 = 4; i3 < 9; i3++) {
            cell = row.insertCell()
            cell.innerText = element[i3].value;

        }
    });
    document.querySelector('span[id="total"]').innerText = data_form.length;
}
function validateProduct(data_product) {
    console.log(`data no validator: ${data_product}`)
    $.ajax({
        url: `${window.location.origin}/api/dashboard/projects/invoiceProducts/validate`,
        type: 'POST',
        headers: { "Authorization": `Bearer ${$("meta[name='api_token']").attr("content")}` },
        data: data_product,
        processData: false,
        contentType: false,
        success: function (response) {
            console.log(response)
        },
        error: function (jqXHR, textStatus, errorThrown) {
            return {
                success: false,
                errors: jqXHR.responseJSON.errors
            }
        }
    })
    // $("#value_unid").inputmask('currency', {
    //     "autoUnmask": true,
    //     radixPoint: ",",
    //     groupSeparator: ".",
    //     allowMinus: false,
    //     prefix: 'R$ ',
    //     digits: 2,
    //     digitsOptional: false,
    //     rightAlign: true,
    //     unmaskAsNumber: true
    // });
}
$(document).on('select2:open', () => {
    document.querySelector('.select2-search__field').focus();

});

//formatação para moeda real BRL
document.getElementById('value_unid').addEventListener('input', function (event) {
    const value = event.target.value;
    event.target.value = formatCurrency(value);
});

function formatCurrency(value) {
    value = value.replace(/\D/g, ''); // Remove todos os caracteres não numéricos
    value = (value / 100).toFixed(2) + ''; // Divide por 100 e fixa em 2 casas decimais
    value = value.replace('.', ','); // Substitui o ponto pela vírgula
    value = value.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.'); // Insere o ponto como separador de milhar
    return 'R$ ' + value; // Adiciona o símbolo de real
}

function setCurrencyValue(amount) {
    const currencyInput = document.getElementById('value_unid');
    const formattedValue = formatCurrency((amount * 100).toFixed(0));
    currencyInput.value = formattedValue;
}

function removeCurrencyMask(id) {
    input = document.getElementById(id)
    value = input.value
    value = value.replace(/[^\d,]/g, ''); // Remove todos os caracteres não numéricos exceto a vírgula
    value = value.replace(',', '.'); // Substitui a vírgula decimal por ponto
    input.value = parseFloat(value); // Converte para número de ponto flutuante
}
// fim formatação moedas 

//modal events
$('#listInvoicesModal').on('show.bs.modal', function (e) {
    $.ajax({
        url: `${window.location.origin}/js/datatable_lang.json`,
        success: function (result) {
            table = new DataTable("#nfs", {
                ajax: `${window.location.origin}/api/dashboard/projects/${extractNumber(window.location.href)}/invoices`,
                stateSave: true,
                bDestroy: true,
                columns: [
                    {
                        data: 'id'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'value',
                        render: (value) => {
                            return formatCurrency(value)
                        }
                    },
                    {
                        data: 'id',
                        render: function (data, type) {
                            return `<a href="${window.location.origin}/dashboard/notas/${data}" target="_blank"
                                    class="text-danger"><i class="fa fa-file-pdf  ml-3 fa-xl" aria-hidden="true"></i></a>`
                        }
                    },
                    {
                        data: 'id',
                        render: (id) => {
                            return `<div class="dropdown show drop-show dropdown-bg-primary">
                                <a class="btn btn-sm btn-secondary dropdown-toggle link-drop" href="#" role="button"
                                    id="dropdownMenuLink-${id}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Opções
                                </a>

                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink-${id}">
                                    <a class="dropdown-item" type="button" onclick="loadInvoiceProducts(${id})">Ver produtos</a>
                                    <a class="dropdown-item"
                                        href="{{ route('dashboard.employees.formlists', $item) }}">Adicionar protudos</a>
                                    <a class="dropdown-item" href="{{ route('dashboard.employees.projects', $item)}}">Editar</a>
                                    <a class="dropdown-item bg-danger" href="{{ route('dashboard.employees.projects', $item)}}">Deletar</a>

                                </div>
                            </div>`
                        }
                    }
                ],
                responsive: true,
                order: [0, 'desc'],
                "language": result,
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, 'Tudo'],
                ],
            })
        }
    });

    // dropdown line bg aplly
    setTimeout(() => {

        nfs = document.getElementById("nfs")
        $(".drop-show").on("hidden.bs.dropdown", (d) => {
            $(d.currentTarget).parent().parent().removeClass("bg-info")
            if (nfs.rows.length < 6) {
                nfs.style.height = ""
            }
        })
        $(".drop-show").on("show.bs.dropdown", (d) => {
            $(d.currentTarget).parent().parent().addClass("bg-info")
            if (nfs.rows.length < 6) {
                nfs.style.height = "220px"
            }
        })

        $('.link-drop').on('show.bs.dropdown', function () {
            this.parentElement.parentElement.parentElement.classList.toggle("bg-info")
        })
        $('.link-drop').on('hide.bs.dropdown', function () {
            this.parentElement.parentElement.parentElement.classList.toggle("bg-info")
        })
    }, 1000)
})

async function loadInvoiceProducts(invoice_id){
    // closeModal('listInvoiceModal')
    // openModal('listInvoiceProductsModal')
    $.ajax({
        url: await getRouteByName('api.projects.invoice.products',{invoice: invoice_id}),
        type: "GET",
        success: (products) => {
            if (products.products.length == 0) {
                Swal.fire({
                    title: "Produtos em notas.",
                    text: `A nota: ${products.invoice.name}, Não possui produtos`,
                    icon: 'info'
                })
            }else{
                Swal.fire({
                    title: "Produtos em notas.",
                    text: "exibindo produtos",
                    icon: 'success'
                })
            }
        }
    })
}

function extractNumber(url) {
    const regex = /\/projects\/(\d+)\//;
    const match = url.match(regex);
    return match ? match[1] : null;
}

 async function getRouteByName(name, params) {
    params = JSON.stringify(params);
    route = await $.get(`${window.location.origin}/api/dashboard/routes/${name}/${params}`).then((rt) => rt);
    return route;
}
