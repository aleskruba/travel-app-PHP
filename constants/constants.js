const countryNamesObjects = [
    { value: 'Francie', label: 'Francie' },
    { value: 'Španělsko', label: 'Španělsko' },
    { value: 'Spojené státy', label: 'Spojené státy' },
    { value: 'Čína', label: 'Čína' },
    { value: 'Itálie', label: 'Itálie' },
    { value: 'Mexiko', label: 'Mexiko' },
    { value: 'Spojené království', label: 'Spojené království' },
    { value: 'Turecko', label: 'Turecko' },
    { value: 'Německo', label: 'Německo' },
    { value: 'Thajsko', label: 'Thajsko' },
    { value: 'Rakousko', label: 'Rakousko' },
    { value: 'Řecko', label: 'Řecko' },
    { value: 'Japonsko', label: 'Japonsko' },
    { value: 'Malajsie', label: 'Malajsie' },
    { value: 'Rusko', label: 'Rusko' },
    { value: 'Portugalsko', label: 'Portugalsko' },
    { value: 'Kanada', label: 'Kanada' },
    { value: 'Saúdská Arábie', label: 'Saúdská Arábie' },
    { value: 'Jižní Korea', label: 'Jižní Korea' },
    { value: 'Austrálie', label: 'Austrálie' },
    { value: 'Nizozemsko', label: 'Nizozemsko' },
    { value: 'Egypt', label: 'Egypt' },
    { value: 'Indie', label: 'Indie' },
    { value: 'Vietnam', label: 'Vietnam' },
    { value: 'Indonésie', label: 'Indonésie' },
    { value: 'Švýcarsko', label: 'Švýcarsko' },
    { value: 'Argentina', label: 'Argentina' },
    { value: 'Švédsko', label: 'Švédsko' },
    { value: 'Polsko', label: 'Polsko' },
    { value: 'Česká republika', label: 'Česká republika' },
    { value: 'Belgie', label: 'Belgie' },
    { value: 'Norsko', label: 'Norsko' },
    { value: 'Dánsko', label: 'Dánsko' },
    { value: 'Singapur', label: 'Singapur' },
    { value: 'Finsko', label: 'Finsko' },
    { value: 'Maroko', label: 'Maroko' },
    { value: 'Brazílie', label: 'Brazílie' },
    { value: 'Spojené arabské emiráty', label: 'Spojené arabské emiráty' },
    { value: 'Irsko', label: 'Irsko' },
    { value: 'Maďarsko', label: 'Maďarsko' },
    { value: 'Izrael', label: 'Izrael' },
    { value: 'Filipíny', label: 'Filipíny' },
    { value: 'Chile', label: 'Chile' },
    { value: 'Nový Zéland', label: 'Nový Zéland' },
    { value: 'Jižní Afrika', label: 'Jižní Afrika' },
    { value: 'Peru', label: 'Peru' },
    { value: 'Rumunsko', label: 'Rumunsko' },
    { value: 'Chorvatsko', label: 'Chorvatsko' },
    { value: 'Keňa', label: 'Keňa' },
    { value: 'Srí Lanka', label: 'Srí Lanka' },
    { value: 'Írán', label: 'Írán' },
    { value: 'Kolumbie', label: 'Kolumbie' },
    { value: 'Hongkong', label: 'Hongkong' },
    { value: 'Tanzanie', label: 'Tanzanie' },
    { value: 'Ukrajina', label: 'Ukrajina' },
    { value: 'Bulharsko', label: 'Bulharsko' },
    { value: 'Srbsko', label: 'Srbsko' },
    { value: 'Katar', label: 'Katar' },
    { value: 'Lucembursko', label: 'Lucembursko' },
    { value: 'Slovensko', label: 'Slovensko' },
    { value: 'Lotyšsko', label: 'Lotyšsko' },
    { value: 'Litva', label: 'Litva' },
    { value: 'Estonsko', label: 'Estonsko' },
    { value: 'Bahrajn', label: 'Bahrajn' },
    { value: 'Kypr', label: 'Kypr' },
    { value: 'Malta', label: 'Malta' },
    { value: 'Černá Hora', label: 'Černá Hora' },
    { value: 'Omán', label: 'Omán' },
    { value: 'Panama', label: 'Panama' },
    { value: 'Arménie', label: 'Arménie' },
    { value: 'Bosna a Hercegovina', label: 'Bosna a Hercegovina' },
    { value: 'Jordánsko', label: 'Jordánsko' },
    { value: 'Gruzie', label: 'Gruzie' },
    { value: 'Albánie', label: 'Albánie' },
    { value: 'Mauricius', label: 'Mauricius' },
    { value: 'Kuvajt', label: 'Kuvajt' },
    { value: 'Libanon', label: 'Libanon' },
    { value: 'Kostarika', label: 'Kostarika' },
    { value: 'Uruguay', label: 'Uruguay' },
    { value: 'Kazachstán', label: 'Kazachstán' },
    { value: 'Bolívie', label: 'Bolívie' },
    { value: 'Guatemala', label: 'Guatemala' },
    { value: 'Ekvádor', label: 'Ekvádor' },
    { value: 'Island', label: 'Island' },
    { value: 'Makedonie', label: 'Makedonie' },
    { value: 'Nepál', label: 'Nepál' },
    { value: 'Paraguay', label: 'Paraguay' },
    { value: 'Zimbabwe', label: 'Zimbabwe' },
    { value: 'Ghana', 'label' : 'Ghana' },
    { value: 'Ázerbájdžán', label: 'Ázerbájdžán' },
    { value: 'Zambie', label: 'Zambie' },
    { value: 'Honduras', label: 'Honduras' },
    { value: 'Jamajka', label: 'Jamajka' },
    { value: 'Etiopie', label: 'Etiopie' },
    { value: 'Kamerun', label: 'Kamerun' },
    { value: 'Madagaskar', label: 'Madagaskar' },
    { value: 'Kuba', label: 'Kuba' }
];