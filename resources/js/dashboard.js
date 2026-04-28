window.petViewer = function (petsData) {
    return {
        pets: petsData,
        index: 0,

       init() {
    this.$watch('index', () => {
        this.renderMap();
    });

    this.$nextTick(() => {
        this.renderMap();
    });


            this.renderMap();
        },

        renderMap() {
            const pet = this.pets[this.index];
            if (!pet || !pet.points) return;

            renderPetMap('map', pet.points);
        }
    }
}