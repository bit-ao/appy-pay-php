# appy-pay-php

SDK/Helper/Adapter em **PHP puro** para facilitar a integração com a API da **AppyPay** — um facilitador de gateway de pagamento para empresas em Angola.  
As APIs seguem princípios **REST**, com nomenclatura orientada a recursos, e as respostas são em **JSON**.

> ⚠️ **Estado**: Este repositório **esta em desenvolvimento**.

> ⚠️ **Aviso legal**: Este projeto é colaborativo e **não** representa, nem é afiliado, patrocinado, endossado ou associado a quaisquer marcas, bancos, operadoras, gateways, agregadores ou entidades citadas.  
<br>Nomes e logótipos mencionados são propriedade dos seus titulares.
As informações aqui reunidas podem ficar **desatualizadas**. Verifica sempre as **fontes oficiais** antes de decisões técnicas ou comerciais.  
<br> Este material é fornecido “**AS IS**”, sem garantias. **Não** constitui aconselhamento jurídico, financeiro ou fiscal.

---

## ✨ Objetivo

Fornecer uma camada simples e segura para:
- **Criar cobranças** (ex.: pagamentos via referência, QR, links);
- **Consultar estados** de pagamento;
- **Validar webhooks**;
- **Tratar erros** com exceções claras e códigos consistentes.

> **Nota:** Este SDK **não** substitui a documentação oficial da AppyPay. Sempre confirme nomes de campos, endpoints e cabeçalhos exigidos nas **fontes oficiais**.

---

## 📦 Instalação

### Via Composer (Packagist)
Quando o pacote estiver publicado:
```bash
composer require bit-ao/appy-pay-php
