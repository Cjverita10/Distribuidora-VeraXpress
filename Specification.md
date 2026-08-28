# 📄 Documento de Especificación de Diseño de Software (SDD)

**Proyecto:** Módulo de Logística y Liquidación de Envíos  
**Empresa / Caso de Estudio:** Distribuidora VeraXpress  
**Tecnología:** PHP 8.x (POO)  

---

## 1. Introducción y Problema
Distribuidora VeraXpress requiere un módulo logístico para calcular dinámicamente el costo total de liquidación de despachos de electrodomésticos. Dado que los productos varían considerablemente en dimensión, peso y nivel de fragilidad (pantallas, cristales), se necesita un sistema flexible que aplique recargos de manera automática sin acoplar la lógica de cálculo al código principal.

---

## 2. Requisitos del Sistema

### 2.1 Requisitos Funcionales
* **`REQ-01` (Carga Pesada):** Si el peso del producto supera los 20 kg, se debe categorizar como `ProductoPesado` e incluir un recargo de flete especial ($60.000 COP).
* **`REQ-02` (Producto Frágil):** Si el producto se marca como delicado (pantallas / vidrios), se debe categorizar como `ProductoFragil` e incluir un recargo por embalaje reforzado y seguro ($25.000 COP).
* **`REQ-03` (Envío Estándar):** Si el producto pesa hasta 10 kg y no es delicado, se debe categorizar como `ProductoEstandard` sin costos adicionales de empaque.

### 2.2 Requisitos No Funcionales
* **`RNF-01` (Extensibilidad):** Cumplimiento del principio Abierto/Cerrado (Open/Closed Principle) para permitir nuevas categorías de envío sin modificar clases existentes.
* **`RNF-02` (Bajo Acoplamiento):** El cliente no debe instanciar clases directamente usando `new`, sino mediante una interfaz unificada.

---

## 3. Arquitectura del Patrón de Diseño: Factory Method

Se implementa el patrón creacional **Factory Method** para desacoplar la creación de objetos de su representación.

+-----------------------+
              |  <<interface>>        |
              |   ProductoInterfaz    |
              +-----------------------+
              | +obtenerNombre()      |
              | +calcularPrecioFinal()|
              | +obtenerDetalle()     |
              +-----------+-----------+
                          ^
    +---------------------+---------------------+
    |                     |                     |
+-------+-------+     +-------+-------+     +-------+-------+
|ProductoEstandard|  | ProductoFragil|     | ProductoPesado|
+---------------+     +---------------+     +---------------+
| $precioBase   |     | $recargoEmpaque\vert{}    \vert{}$fleteCarga   |
+---------------+     +---------------+     +---------------+

                          ^
                          | (Instancia según condiciones)
              +-----------+-----------+
              |   FabricaLogistica    |
              +-----------------------+
              | +crearProducto()      |
              +-----------------------+

---

## 4. Matriz de Decisiones de la Fábrica (`FabricaLogistica`)

| Condición | Tipo de Producto Instanciado | Recargo Aplicado |
| :--- | :--- | :--- |
| `pesoKg > 20` | `ProductoPesado` | + $60.000 COP (Flete) |
| `esDelicado == true` | `ProductoFragil` | + $25.000 COP (Seguro/Empaque) |
| *Por defecto (<= 10 kg)* | `ProductoEstandard` | $0 COP (Empaque cartón) |

---

## 5. Criterios de Aceptación
* **`CA-01`:** El sistema liquidará correctamente un Smart TV calculando el precio base más el seguro de $25.000 COP.
* **`CA-02`:** El sistema detectará un nevecón (>20 kg) y aplicará automáticamente la tarifa de flete especial de $60.000 COP.
