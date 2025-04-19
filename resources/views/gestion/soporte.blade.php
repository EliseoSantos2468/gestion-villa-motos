@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{asset('css/soporte.css')}}">

    <div class="soporte-container">
        <h1>Soporte Villamotos</h1>

        <div class="informacion-empresa">
            <div class="empresa-card">
                <div class="empresa-header">
                    <h2>Información de la Empresa</h2>
                </div>
                <div class="empresa-body">
                    <div class="empresa-dato">
                        <span class="material-symbols-rounded">apartment</span>
                        <p><strong>Nombre:</strong> Villamotos S.A. de C.V.</p>
                    </div>
                    <div class="empresa-dato">
                        <span class="material-symbols-rounded">location_on</span>
                        <p><strong>Dirección:</strong> Av. Los Próceres, San Salvador, El Salvador</p>
                    </div>
                    <div class="empresa-dato">
                        <span class="material-symbols-rounded">call</span>
                        <p><strong>Teléfono:</strong> (503) 2222-2222</p>
                    </div>
                    <div class="empresa-dato">
                        <span class="material-symbols-rounded">mail</span>
                        <p><strong>Correo:</strong> info@villamotos.com</p>
                    </div>
                    <div class="empresa-dato">
                        <span class="material-symbols-rounded">public</span>
                        <p><strong>Sitio Web:</strong> www.villamotos.com</p>
                    </div>
                </div>
            </div>

            <div class="mision-vision">
                <div class="card-mision">
                    <div class="card-header">
                        <span class="material-symbols-rounded">target</span>
                        <h3>Misión</h3>
                    </div>
                    <div class="card-body">
                        <p>Proveer soluciones integrales en el mercado de motocicletas, ofreciendo productos de calidad, servicios excepcionales y financiamiento accesible para contribuir al desarrollo económico de nuestros clientes.</p>
                    </div>
                </div>

                <div class="card-vision">
                    <div class="card-header">
                        <span class="material-symbols-rounded">visibility</span>
                        <h3>Visión</h3>
                    </div>
                    <div class="card-body">
                        <p>Ser la empresa líder en venta y financiamiento de motocicletas en El Salvador, reconocida por nuestra innovación, calidad de servicio y compromiso con el desarrollo de nuestros clientes.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="soporte-contacto">
            <h2>Contacto de Soporte</h2>
            
            <div class="canales-soporte">
                <div class="canal">
                    <span class="material-symbols-rounded">support_agent</span>
                    <h4>Soporte Técnico</h4>
                    <p>soporte@villamotos.com</p>
                    <p>Tel: (503) 2222-3333</p>
                    <p>Horario: L-V 8:00 AM - 5:00 PM</p>
                </div>
                
                <div class="canal">
                    <span class="material-symbols-rounded">credit_card</span>
                    <h4>Soporte Financiero</h4>
                    <p>creditos@villamotos.com</p>
                    <p>Tel: (503) 2222-4444</p>
                    <p>Horario: L-V 8:00 AM - 4:00 PM</p>
                </div>
                
                <div class="canal">
                    <span class="material-symbols-rounded">receipt</span>
                    <h4>Facturación</h4>
                    <p>facturacion@villamotos.com</p>
                    <p>Tel: (503) 2222-5555</p>
                    <p>Horario: L-V 8:00 AM - 3:00 PM</p>
                </div>
            </div>
        </div>

        <div class="formulario-soporte">
            <h2>Formulario de Contacto</h2>
            <form>
                <div class="form-group">
                    <label for="nombre">Nombre Completo</label>
                    <input type="text" id="nombre" class="form-control" placeholder="Ingrese su nombre">
                </div>
                
                <div class="form-group">
                    <label for="correo">Correo Electrónico</label>
                    <input type="email" id="correo" class="form-control" placeholder="Ingrese su correo">
                </div>
                
                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="tel" id="telefono" class="form-control" placeholder="Ingrese su teléfono">
                </div>
                
                <div class="form-group">
                    <label for="asunto">Asunto</label>
                    <select id="asunto" class="form-control">
                        <option value="">Seleccione un asunto</option>
                        <option value="soporte">Soporte Técnico</option>
                        <option value="financiero">Consulta Financiera</option>
                        <option value="facturacion">Facturación</option>
                        <option value="otro">Otro</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="mensaje">Mensaje</label>
                    <textarea id="mensaje" class="form-control" rows="4" placeholder="Describa su consulta"></textarea>
                </div>
                
                <button type="submit" class="btn-enviar">
                    <span class="material-symbols-rounded">send</span>
                    Enviar Mensaje
                </button>
            </form>
        </div>
    </div>
@endsection