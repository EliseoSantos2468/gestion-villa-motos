const cotizadorForm = document.getElementById('cotizadorForm');
    const resultadosDiv = document.getElementById('resultados');
    const cuotaSpan = document.getElementById('cuota');
    const totalPagarSpan = document.getElementById('totalPagar');
    const interesTotalSpan = document.getElementById('interesTotal');
    const tablaAmortizacionBody = document.getElementById('tablaAmortizacionBody');


    cotizadorForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const monto = parseFloat(document.getElementById('monto').value);
        const plazo = parseInt(document.getElementById('plazo').value);
        const interesAnual = parseFloat(document.getElementById('interes').value);
        const frecuencia = document.getElementById('frecuencia').value;

        if (isNaN(monto) || monto <= 0) {
            Swal.fire({ icon: 'error', title: 'Error', text: 'Por favor, ingrese un monto válido mayor que cero.' });
            return;
        }
        if (isNaN(plazo) || plazo <= 0) {
            Swal.fire({ icon: 'error', title: 'Error', text: 'Por favor, ingrese un plazo válido mayor que cero.' });
            return;
        }
        if (isNaN(interesAnual) || interesAnual < 0) {
            Swal.fire({ icon: 'error', title: 'Error', text: 'Por favor, ingrese una tasa de interés válida mayor o igual a cero.' });
            return;
        }

        let frecuenciaPago = 0;
        let frecuenciaTexto = "";
        switch (frecuencia) {
            case 'mensual':
                frecuenciaPago = 1;
                frecuenciaTexto = "Mensual";
                break;
            case 'quincenal':
                frecuenciaPago = 2;
                frecuenciaTexto = "Quincenal";
                break;
            case 'semanal':
                frecuenciaPago = 4;
                frecuenciaTexto = "Semanal";
                break;
            default:
                frecuenciaPago = 1;
                frecuenciaTexto = "Mensual";
        }

        const interesMensual = interesAnual / 100 / 12;
        const factor = (1 - Math.pow(1 + interesMensual, -plazo));
        const cuota = monto * (interesMensual / factor);
        const totalPagar = cuota * plazo;
        const interesTotal = totalPagar - monto;

        cuotaSpan.textContent = cuota.toFixed(2);
        totalPagarSpan.textContent = totalPagar.toFixed(2);
        interesTotalSpan.textContent = interesTotal.toFixed(2);
        resultadosDiv.style.display = 'block';
        tablaAmortizacionBody.innerHTML = '';
        generarTablaAmortizacion(monto, plazo, interesMensual, cuota, frecuenciaPago, frecuenciaTexto);
    });

    function generarTablaAmortizacion(montoInicial, plazoEnMeses, interesMensual, cuotaFija, frecuenciaPago, frecuenciaTexto) {
        let saldo = montoInicial;
        let tablaHTML = '';
        let periodoTexto = "";
        for (let periodo = 1; periodo <= plazoEnMeses * frecuenciaPago; periodo++) {

            switch(frecuenciaTexto){
                case "Mensual":
                    periodoTexto = `Mes ${periodo}`;
                    break;
                case "Quincenal":
                    periodoTexto = `Quincena ${periodo}`;
                    break;
                case "Semanal":
                    periodoTexto = `Semana ${periodo}`;
                    break;
                default:
                    periodoTexto = `Mes ${periodo}`;
            }
            const interes = saldo * interesMensual / frecuenciaPago;
            const amortizacion = cuotaFija - interes;
            saldo -= amortizacion;

            tablaHTML += `
                <tr>
                    <td>${periodoTexto}</td>
                    <td>${saldo.toFixed(2)}</td>
                    <td>${cuotaFija.toFixed(2)}</td>
                    <td>${interes.toFixed(2)}</td>
                    <td>${amortizacion.toFixed(2)}</td>
                    <td>${saldo.toFixed(2)}</td>
                </tr>
            `;
        }
        tablaAmortizacionBody.innerHTML = tablaHTML;
    }
    