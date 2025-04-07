package Assignment_01.Question_07;

import java.util.ArrayList;
import java.util.List;

public class Stack {
    private Integer bottom;
    private Integer top;
    private List<Integer> elements;

//  Constructor, it receives a list of integers as param
    public Stack( List<Integer> integers ){
        this.setElements(integers);
        this.setTop( this.getElements().get(this.getElements().size()-1) );
        this.setBottom( this.getElements().get(0) );
    }

    public Integer getBottom() {
        return bottom;
    }

    public void setBottom(Integer bottom) {
        this.bottom = bottom;
    }

    public Integer getTop() {
        return top;
    }

    public void setTop(Integer top) {
        this.top = top;
    }

    public List<Integer> getElements() {
        return elements;
    }

    public void setElements(List<Integer> elements) {
        this.elements = elements;
    }

//  add elements to the stack (@params: number of elements to be inserted, array of new elements)
    public void push( int nElements, List<Integer> newElementsArray ){
        ArrayList<Integer> updatedStack = new ArrayList<>(this.getElements());

        for( int i=0; i<nElements; i++ ){
            updatedStack.add(newElementsArray.get(i));
            this.setElements(updatedStack);
            this.setTop(updatedStack.get(updatedStack.size() - 1));
        }
    }

//  Pop n values
    public ArrayList<Integer> pop( int n ){
        List<Integer> updatedList = this.getElements();
        ArrayList<Integer> removedElements = new ArrayList<>();

        if( n > this.getElements().size() ){
            throw new IndexOutOfBoundsException("Tried to remove more elements than the list has.");
        }

        for( int i=0; i<n; i++ ){
            removedElements.add(updatedList.remove(this.getElements().size() - 1));
        }
//        System.out.println("elements removed: " + removedElements);

        this.setElements( updatedList );
        this.setTop( updatedList.get(updatedList.size() - 1) );

        return removedElements;
    }
}
