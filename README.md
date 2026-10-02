# VeraXpress Logistics - Sistema de Liquidación de Envíos

Módulo en consola desarrollado en C# / .NET para la clasificación dinámica de productos, cálculo de costos de despacho y asignación de empaques en **VeraXpress**.

## 📋 Resumen del Problema
VeraXpress requiere automatizar el cálculo de tarifas y asignación de empaques para los envíos. Dependiendo de si un producto supera los 20 kg o si es delicado, se deben aplicar sobrecostos por flete o empaque reforzado con seguro.

## 🛠️ Patrón de Diseño Implementado

* **Simple Factory (`FabricaLogistica`):** Centraliza la lógica de decisión en el método `CrearProducto()`. Evalúa los parámetros ($pesoKg$ y $esDelicado$) e instancia la clase concreta adecuada (`ProductoPesado`, `ProductoFragil` o `ProductoEstandard`), desacoplando la creación del objeto respecto a la ejecución principal.

## 🚀 Instrucciones de Ejecución

### Requisitos
* [.NET SDK 6.0](https://dotnet.microsoft.com/download) o superior.

### Ejecución
1. Abre una terminal en la carpeta raíz del proyecto.
2. Ejecuta el siguiente comando:

```bash
dotnet run
