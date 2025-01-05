-- -- Tworzenie bazy danych

-- Tabela zajecia
CREATE TABLE zajecia (
    id_zajec INT AUTO_INCREMENT PRIMARY KEY,
    id_przedmiotu INT NOT NULL,
    id_prowadzacego INT NOT NULL,
    id_sali INT NOT NULL,
    id_grupy INT NOT NULL,
    data_zajec DATE NOT NULL,
    godzina_rozpoczecia TIME NOT NULL,
    godzina_zakonczenia TIME NOT NULL,
    FOREIGN KEY (id_przedmiotu) REFERENCES przedmiot(id_przedmiotu) ON DELETE CASCADE,
    FOREIGN KEY (id_prowadzacego) REFERENCES prowadzacy(id_prowadzacego) ON DELETE CASCADE,
    FOREIGN KEY (id_sali) REFERENCES sala(id_sali) ON DELETE CASCADE,
    FOREIGN KEY (id_grupy) REFERENCES grupa(id_grupy) ON DELETE CASCADE
);
