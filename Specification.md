# 📄 Documento de Especificación de Diseño de Software (SDD)

**Proyecto:** Módulo de Logística y Liquidación de Envíos  
**Empresa / Caso de Estudio:** Distribuidora VeraXpress  
**Tecnología:** C# (.NET 6.0+) — Programación Orientada a Objetos  

---

## 1. Introducción y Problema

Distribuidora VeraXpress requiere un módulo logístico para calcular dinámicamente el costo total de liquidación de despachos de electrodomésticos. Dado que los productos varían considerablemente en dimensión, peso y nivel de fragilidad (pantallas, cristales), se necesita un sistema flexible que aplique recargos de manera automática sin acoplar la lógica de cálculo al código principal.

---

## 2. Requisitos del Sistema

### 2.1 Requisitos Funcionales

* **REQ-01 (Carga Pesada):** Si el peso del producto supera los 20 kg, se debe categorizar como `ProductoPesado` e incluir un recargo de flete especial ($60.000 COP).
* **REQ-02 (Producto Frágil):** Si el producto se marca como delicado (pantallas / vidrios) y no supera los 20 kg, se debe categorizar como `ProductoFragil` e incluir un recargo por embalaje reinforced y seguro ($25.000 COP).
* **REQ-03 (Envío Estándar):** Si el producto no es delicado y pesa hasta 20 kg, se debe categorizar como `ProductoEstandard` sin costos adicionales de empaque.

### 2.2 Requisitos No Funcionales

* **RNF-01 (Extensibilidad):** Cumplimiento del principio Abierto/Cerrado (OCP) para permitir nuevas categorías de envío sin modificar las clases de dominio existentes.
* **RNF-02 (Bajo Acoplamiento):** El código cliente debe interactuar únicamente con la interfaz `IProducto`, delegando la instanciación a un componente creacional centralizado.

---

## 3. Arquitectura del Patrón de Diseño: Factory Pattern

Se implementa un patrón creacional (Fábrica) para encapsular las reglas de negocio de instanciación y desacoplar al cliente de la lógica de decisión de objetos.

```text
                  +--------------------------+
                  |  <<interface>>           |
                  |  IProducto               |
                  +--------------------------+
                  | +ObtenerNombre()         |
                  | +CalcularPrecioFinal()   |
                  | +ObtenerDetalleLogistica()
                  +------------+-------------+
                               ^
                               | (Implementan)
      +------------------------+------------------------+
      |                        |                        |
+-----+--------------+  +------+---------------+  +-----+--------------+
| ProductoEstandard  |  | ProductoFragil       |  | ProductoPesado     |
+--------------------+  +----------------------+  +--------------------+
| - _nombre          |  | - _nombre            |  | - _nombre          |
| - _precioBase      |  | - _precioBase        |  | - _precioBase      |
|                    |  | - _recargoEmpaque    |  | - _fleteCarga      |
+--------------------+  +----------------------+  +--------------------+

                               ^
                               | (Instancia según condiciones)
                  +------------+-------------+
                  | FabricaLogistica         |
                  +--------------------------+
                  | +CrearProducto()         |
                  +--------------------------+
