setup
	-kysyy config tiedostoon juttuja
	-org nimi dropdown palkilla (uusi tekstikentällä)
	-muut voi joko täyttää tekstikenttiin tai jättää tyhjiksi.

config
	-mitä tänne ny ikinä tarviikaan

installer
	-lukee config tiedoston ja luo sen perusteella uuden halkomaatin tietokantaan ja
	 asentaa laitteen omaan tallennustilaan uuden halkomaattisovelluksen,
         joka käynnistyy aina laitteen käynnistyessä.
	-jos laitteessa on jo halkomaattia ajava sovellus, installer sulkee sen ja
	 käynnistää raspberryn uudelleen asennettuaan uuden halkomaatti sovelluksen.

halkomaatti sovellus ( installerin luoma )
	-tekee taikojaan...
	-käynnistyessään tarkistaa onko laitteeseen kytketty usb tikku
		-jos näin on, käynnistää sovellus uuden installerin.
