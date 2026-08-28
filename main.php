<?php

// 1. Interfaz común
interface ProductoInterfaz {
    public function obtenerNombre(): string;
    public function calcularPrecioFinal(): float;
    public function obtenerDetalleLogistica(): string;
}

// 2. Clases Concretas
class ProductoEstandard implements ProductoInterfaz {
    public function __construct(private string $nombre, private float $precioBase) {}
    public function obtenerNombre(): string { return $this->nombre; }
    public function calcularPrecioFinal(): float { return $this->precioBase; }
    public function obtenerDetalleLogistica(): string { return "Despacho Estándar (Empaque de cartón sin recargo)"; }
}

class ProductoFragil implements ProductoInterfaz {
    private float $recargoEmpaque = 25000;
    public function __construct(private string $nombre, private float $precioBase) {}
    public function obtenerNombre(): string { return $this->nombre; }
    public function calcularPrecioFinal(): float { return $this->precioBase + $this->recargoEmpaque; }
    public function obtenerDetalleLogistica(): string { return "Producto Delicado / Pantalla (Empaque reforzado + seguro: $25.000 COP)"; }
}

class ProductoPesado implements ProductoInterfaz {
    private float $fleteCarga = 60000;
    public function __construct(private string $nombre, private float $precioBase) {}
    public function obtenerNombre(): string { return $this->nombre; }
    public function calcularPrecioFinal(): float { return $this->precioBase + $this->fleteCarga; }
    public function obtenerDetalleLogistica(): string { return "Carga Pesada (>20 kg) (Flete especial + 2 operarios: $60.000 COP)"; }
}

// 3. Fábrica (Factory Method)
class FabricaLogistica {
    public static function crearProducto(string $nombre, float $precioBase, float $pesoKg, bool $esDelicado): ProductoInterfaz {
        // Regla 1: Si pesa más de 20 kg -> Carga Pesada
        if ($pesoKg > 20) {
            return new ProductoPesado($nombre, $precioBase);
        }
        
        // Regla 2: Si es delicado (pantalla/vidrio) -> Producto Frágil
        if ($esDelicado) {
            return new ProductoFragil($nombre, $precioBase);
        }

        // Regla 3: Hasta 10 kg y no delicado -> Estándar (Cartón)
        return new ProductoEstandard($nombre, $precioBase);
    }
}

// 4. Catálogo de prueba
$catalogoPrueba = [
    [
        "nombre" => "Radio Portátil Bluetooth", 
        "precio" => 65000,   
        "peso" => 0.8,  
        "delicado" => false, 
        "nota" => "Hasta 10 kg y no delicado -> Despacho estándar en caja de cartón"
    ],
    [
        "nombre" => "Smart TV 55 OLED 4K", 
        "precio" => 1800000, 
        "peso" => 12.0, 
        "delicado" => true,  
        "nota" => "Producto delicado (pantalla) -> Empaque reforzado con seguro"
    ],
    [
        "nombre" => "Nevecón No Frost 520L", 
        "precio" => 3200000, 
        "peso" => 80.0, 
        "delicado" => false, 
        "nota" => "Pesa más de 20 kg -> Aplica flete de carga pesada"
    ]
];

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Distribuidora VeraXpress - Envios</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #0f172a; color: #f8fafc; padding: 40px; }
        .container { max-width: 680px; margin: auto; }
        h2 { text-align: center; color: #38bdf8; margin-bottom: 25px; font-size: 22px; text-transform: uppercase; letter-spacing: 1px; }
        details { background: #1e293b; border: 1px solid #334155; border-radius: 8px; margin-bottom: 15px; padding: 12px 18px; cursor: pointer; transition: 0.2s; }
        details[open] { border-color: #38bdf8; }
        summary { font-weight: bold; font-size: 17px; color: #f1f5f9; outline: none; }
        summary:hover { color: #38bdf8; }
        .content { margin-top: 15px; padding-top: 12px; border-top: 1px solid #334155; font-size: 14px; line-height: 1.6; color: #cbd5e1; }
        .tag { display: inline-block; padding: 2px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; margin-left: 8px; }
        .tag-peso { background: #334155; color: #38bdf8; }
        .price-box { margin-top: 10px; padding: 10px; background: #0f172a; border-radius: 6px; font-weight: bold; font-size: 16px; color: #4ade80; text-align: right; }
    </style>
</head>
<body>

<div class="container">
    <h2>Distribuidora VeraXpress - Logistics</h2>

    <?php foreach ($catalogoPrueba as $item): 
        $producto = FabricaLogistica::crearProducto(
            $item["nombre"], 
            $item["precio"], 
            $item["peso"], 
            $item["delicado"]
        );
    ?>
        <details>
            <summary>
                <?= $producto->obtenerNombre(); ?>
                <span class="tag tag-peso"><?= $item["peso"]; ?> kg</span>
            </summary>
            <div class="content">
                <p><strong>Precio Base:</strong> $<?= number_format($item["precio"], 0, ',', '.'); ?> COP</p>
                <p><strong>Peso registrado:</strong> <?= $item["peso"]; ?> kg</p>
                <p><strong>¿Es Delicado / Pantalla?:</strong> <?= $item["delicado"] ? 'Sí' : 'No'; ?></p>
                <p><strong>Criterio Aplicado:</strong> <?= $item["nota"]; ?></p>
                <p><strong>Detalle del Despacho:</strong> <?= $producto->obtenerDetalleLogistica(); ?></p>
                <div class="price-box">
                    TOTAL LIQUIDADO: $<?= number_format($producto->calcularPrecioFinal(), 0, ',', '.'); ?> COP
                </div>
            </div>
        </details>
    <?php endforeach; ?>
</div>

</body>
</html>