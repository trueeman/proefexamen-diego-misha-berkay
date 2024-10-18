
# Proefexamen
test

## Teamleden

- **Berkay**
- **Diego**
- **Misha**

## Projectstructuur

- **/docs/**: Bevat documentatie zoals projectvereisten en definities.
  
- **/standups/**: Bevat wekelijkse voortgangsrapporten van stand-ups.
  
- **/burndown/**: Burndown charts en andere tracking tools voor het project.

- **/project/**: Hier staat de broncode.

- **/erd/**: Hier staan database ERDs

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

5. **Voer de db.sql file uit in uw DBMS**

6. **Start de server**  
   ```bash
   php -S localhost:8000 -t .\project\public_html\
   ```
