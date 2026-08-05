window.petViewer = function (petsData) {
    return {
        pets: Object.values(petsData),
        index: 0,

        init() {
            this.$watch('index', () => {
                this.renderMap();
            });

            this.$nextTick(() => {
                this.renderMap();
            });
        },

        renderMap() {
            const pet = this.pets[this.index];
            if (!pet || !pet.points) return;

            window.renderPetMap('map', pet.points);
        }
    };
};