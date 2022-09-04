document.addEventListener("DOMContentLoaded", async () => {
    // https://economia.awesomeapi.com.br/last/USD-BRL

    const dolarValue = await getDollarToday();
    // ${Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(1)} |
    document.querySelector("#dollar_value").innerHTML = `
    ${Intl.NumberFormat("pt-BR", { style: "currency", currency: "BRL" }).format(
        dolarValue
    )}`;
});

document.addEventListener("DOMContentLoaded", async () => {
    const dolarValue2 = await getDollarToday2();
    document.querySelector("#dollar_value2").innerHTML = `
    ${Intl.NumberFormat("pt-BR", { style: "currency", currency: "BRL" }).format(
        dolarValue2
    )}`;
});

async function getDollarToday() {
    const res = await fetch("https://economia.awesomeapi.com.br/last/USD-BRL");
    const data = await res.json();
    return data.USDBRL.high;
}

async function getDollarToday2() {
    const res = await fetch("https://economia.awesomeapi.com.br/last/USD-BRL");
    const data = await res.json();
    return data.USDBRL.bid;
}
