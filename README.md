
# Proefexamen

## Teamleden

- **Berkay**
- **Diego**
- **Misha**

## Projectstructuur

- **/docs/**: Bevat documentatie zoals projectvereisten en definities.
    - [Examenafspraken B1K1 & B1K2](./docs/Examenafspraken_B1K1_B1K2.pdf)
    - [Proefexamen Definition of Done](./docs/Proefexamen_Definition_of_Done.docx)
  
- **/standups/**: Bevat wekelijkse voortgangsrapporten van stand-ups.
  
- **/burndown/**: Burndown charts en andere tracking tools voor het project.
    - [Burndown Chart Verkiezingen](./burndown/burndown-verkiezingen-d-m-b.xlsx)

- **/project/**: Hier staat de broncode.

Bekijk de documentatie in de `docs`-map voor instructies.

## Planning en voortgang

Bekijk de [burndown charts](./burndown/) voor de huidige status van de projectvoortgang. Wekelijkse updates kunnen worden gevolgd via de [stand-ups](./standups/).

## Ontwerp

Wireframes en andere ontwerpgerelateerde bestanden worden opgeslagen in de [design map](./design/) (indien van toepassing).

## Installatie

Volg deze stappen om het project lokaal te installeren:

1. **Clone de repository**  
   ```bash
   git clone https://github.com/trueeman/proefexamen-diego-misha-berkay.git
   ```

2. **Navigeer naar het project**  
   ```bash
   cd proefexamen-diego-misha-berkay
   ```

3. **Installeer dependencies**  
   ```bash
   composer install
   ```

4. **Projectinstellingen kopiëren**  
   ```bash
   cp .env.template .env
   ```

5. **Start de server**  
   ```bash
   php -S localhost:8000 -t .
   ```
