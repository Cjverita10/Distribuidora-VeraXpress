# 📦 Distribuidora VeraXpress - Logistics

Sistema de liquidación de despachos y cálculo dinámico de costos de envío para electrodomésticos, desarrollado en **PHP 8** bajo el patrón de diseño creacional **Factory Method**.

---

## 🛠️ Arquitectura del Sistema

El proyecto implementa la separación de responsabilidades (*Separation of Concerns*), dividiendo la lógica de negocio de la capa de presentación:

veraxpress-logistica/
├── public/
│   ├── index.php          # Vista y renderizado HTML
│   └── styles.css         # Estilos UI (Tema oscuro)
├── specs/
│   └── specification.md   # Especificación técnica (SDD)
├── src/
│   └── Producto.php       # Interfaz, clases concretas y Fábrica
└── README.md              # Documentación general


---

## 💡 Patrón Factory Method y Reglas de Negocio

La fábrica (`FabricaLogistica`) centraliza la creación de objetos dinámicamente mediante la evaluación de reglas de negocio sobre el peso y la delicadeza del producto:

* **`ProductoPesado` (> 20 kg):** Aplica un recargo de **$60.000 COP** por concepto de flete especial y 2 operarios (ej. Nevecones, lavadoras).
* **`ProductoFragil` (Pantalla / Vidrio):** Aplica un recargo de **$25.000 COP** por empaque reforzado con burbuja y seguro (ej. Smart TVs).
* **`ProductoEstandard` (<= 10 kg):** Envíos básicos en caja de cartón sin costo adicional de empaque (ej. Radios portátiles).

---

## 🚀 Instalación y Ejecución Local

1. Clona o descarga este repositorio en tu directorio de servidor web:
   `C:\xampp\htdocs\veraxpress-logistica\`
2. Inicia el servicio **Apache** en el *XAMPP Control Panel*.
3. Abre tu navegador e ingresa a la siguiente URL:
   `http://localhost/src/main.php`
